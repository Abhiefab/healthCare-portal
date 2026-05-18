<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\DoctorProfile;
use App\Models\Appointment;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_doctor_can_register_and_gets_profile_row(): void
    {
        $response = $this->post('/signup', [
            'role' => 'doctor',
            'first_name' => 'Asha',
            'last_name' => 'Mehta',
            'email' => 'asha.mehta@gmail.com',
            'password' => 'StrongPass1',
            'password_confirmation' => 'StrongPass1',
            'terms' => '1',
        ]);

        $user = User::where('email', 'asha.mehta@gmail.com')->firstOrFail();

        $response->assertRedirect(route('doctor.dashboard'));
        $this->assertAuthenticatedAs($user);
        $this->assertSame('Asha Mehta', $user->name);
        $this->assertSame('doctor', $user->role);
        $this->assertTrue(Hash::check('StrongPass1', $user->password));
        $this->assertDatabaseHas('doctor_profiles', [
            'user_id' => $user->id,
            'status' => 'Available',
        ]);
    }

    public function test_registration_reports_invalid_data(): void
    {
        $response = $this->from('/signup')->post('/signup', [
            'role' => 'manager',
            'first_name' => '',
            'last_name' => '',
            'email' => 'bad-email',
            'password' => 'short',
            'password_confirmation' => 'different',
        ]);

        $response
            ->assertRedirect('/signup')
            ->assertSessionHasErrors(['role', 'first_name', 'last_name', 'email', 'password', 'terms']);
    }

    public function test_login_rejects_wrong_credentials(): void
    {
        User::factory()->create([
            'email' => 'patient@gmail.com',
            'password' => 'CorrectPass1',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'patient@gmail.com',
            'password' => 'WrongPass1',
        ]);

        $response
            ->assertRedirect('/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_redirects_by_role_to_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'patient@gmail.com',
            'password' => 'CorrectPass1',
            'role' => 'patient',
        ]);

        $response = $this->post('/login', [
            'email' => 'patient@gmail.com',
            'password' => 'CorrectPass1',
        ]);

        $response->assertRedirect(route('patient.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_seeded_admin_can_login_to_admin_dashboard(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->post('/login', [
            'email' => 'shashwat@admin.healthcare.test',
            'password' => 'Admin@12345',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_seeded_doctors_render_on_public_and_admin_dashboards(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseHas('users', [
            'email' => 'michael.carter@doctor.healthcare.test',
            'role' => 'doctor',
        ]);
        $this->assertDatabaseHas('doctor_profiles', [
            'specialization' => 'Orthopedics',
            'review_count' => 230,
        ]);

        $this->get(route('doctors'))
            ->assertOk()
            ->assertSee('Dr. Michael Carter')
            ->assertSee('Orthopedic Surgeon');

        $admin = User::where('email', 'shashwat@admin.healthcare.test')->firstOrFail();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dr. Michael Carter')
            ->assertSee('Total Doctors');
    }

    public function test_doctors_directory_filters_by_search_specialization_and_status(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get(route('doctors', ['q' => 'Orthopedic']))
            ->assertOk()
            ->assertSee('Dr. Michael Carter')
            ->assertDontSee('Dr. Sarah Johnson');

        $this->get(route('doctors', ['specialization' => 'Pediatrics']))
            ->assertOk()
            ->assertSee('Dr. Sarah Johnson')
            ->assertDontSee('Dr. Michael Carter');

        $busyDoctor = User::factory()->create([
            'name' => 'Dr. Busy Doctor',
            'email' => 'busy.doctor@healthcare.test',
            'role' => 'doctor',
        ]);
        $busyDoctor->doctorProfile()->create([
            'title' => 'Cardiologist',
            'specialization' => 'Cardiology',
            'status' => 'Busy',
        ]);

        $this->get(route('doctors', ['status' => 'Busy']))
            ->assertOk()
            ->assertSee('Dr. Busy Doctor')
            ->assertDontSee('Dr. Michael Carter');
    }

    public function test_doctors_directory_shows_role_specific_dashboard_return_links(): void
    {
        $this->seed(DatabaseSeeder::class);

        $admin = User::where('email', 'shashwat@admin.healthcare.test')->firstOrFail();
        $doctor = User::where('email', 'michael.carter@doctor.healthcare.test')->firstOrFail();
        $patient = User::where('email', 'patient@healthcare.test')->firstOrFail();

        $this->actingAs($admin)
            ->get(route('doctors', ['from' => 'admin']))
            ->assertOk()
            ->assertSee('Back to Admin Dashboard')
            ->assertSee(route('admin.dashboard'), false);

        $this->actingAs($doctor)
            ->get(route('doctors', ['from' => 'doctor']))
            ->assertOk()
            ->assertSee('Back to Doctor Dashboard')
            ->assertSee(route('doctor.dashboard'), false);

        $this->actingAs($patient)
            ->get(route('doctors', ['from' => 'patient']))
            ->assertOk()
            ->assertSee('Back to Patient Dashboard')
            ->assertSee(route('patient.dashboard'), false);
    }

    public function test_direct_doctors_directory_visit_does_not_show_dashboard_back_link(): void
    {
        $this->seed(DatabaseSeeder::class);

        $admin = User::where('email', 'shashwat@admin.healthcare.test')->firstOrFail();

        $this->actingAs($admin)
            ->get(route('doctors'))
            ->assertOk()
            ->assertDontSee('Back to Admin Dashboard')
            ->assertDontSee('Admin view');
    }

    public function test_doctors_directory_ignores_mismatched_dashboard_source(): void
    {
        $this->seed(DatabaseSeeder::class);

        $patient = User::where('email', 'patient@healthcare.test')->firstOrFail();

        $this->actingAs($patient)
            ->get(route('doctors', ['from' => 'admin']))
            ->assertOk()
            ->assertDontSee('Back to Admin Dashboard')
            ->assertDontSee('Back to Patient Dashboard')
            ->assertDontSee('Admin view');
    }

    public function test_guest_can_browse_doctors_directory_with_login_actions(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get(route('doctors'))
            ->assertOk()
            ->assertSee('Dr. Michael Carter')
            ->assertSee('Book Appointment')
            ->assertSee(route('login'), false);
    }

    public function test_patient_and_doctor_dashboards_require_authentication(): void
    {
        $this->get(route('patient.dashboard'))->assertRedirect(route('login'));
        $this->get(route('doctor.dashboard'))->assertRedirect(route('login'));
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_authenticated_users_are_redirected_away_from_auth_pages(): void
    {
        $patient = User::factory()->create([
            'role' => 'patient',
        ]);

        $this->actingAs($patient)
            ->get(route('login'))
            ->assertRedirect(route('patient.dashboard'));

        $this->actingAs($patient)
            ->get(route('signup'))
            ->assertRedirect(route('patient.dashboard'));
    }

    public function test_authenticated_public_navbar_shows_session_and_logout(): void
    {
        $user = User::factory()->create([
            'name' => 'Session User',
            'role' => 'patient',
        ]);

        $this->actingAs($user)
            ->get(route('doctors'))
            ->assertOk()
            ->assertSee('Session User')
            ->assertSee('Patient')
            ->assertSee('Dashboard')
            ->assertSee('Logout');
    }

    public function test_logout_invalidates_session_and_blocks_dashboard_access(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();

        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_patient_dashboard_shows_db_doctors(): void
    {
        $this->seed(DatabaseSeeder::class);

        $patient = User::factory()->create([
            'role' => 'patient',
            'password' => 'CorrectPass1',
        ]);

        $this->actingAs($patient)
            ->get(route('patient.dashboard'))
            ->assertOk()
            ->assertSee('Recommended Doctors')
            ->assertSee('Care Overview')
            ->assertSee('Book Available Doctor')
            ->assertSee('Dr. Sarah Johnson');
    }

    public function test_doctor_can_update_availability_and_public_profile(): void
    {
        $this->seed(DatabaseSeeder::class);

        $doctor = User::where('email', 'michael.carter@doctor.healthcare.test')->firstOrFail();

        $this->actingAs($doctor)
            ->put(route('doctor.profile.update'), [
                'title' => 'Senior Orthopedic Surgeon',
                'specialization' => 'Sports Orthopedics',
                'experience_years' => 16,
                'status' => 'Busy',
                'location' => 'Updated Care Center',
                'image_path' => 'images/doctors/doctor5.png',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('doctor_profiles', [
            'user_id' => $doctor->id,
            'title' => 'Senior Orthopedic Surgeon',
            'specialization' => 'Sports Orthopedics',
            'experience_years' => 16,
            'status' => 'Busy',
            'location' => 'Updated Care Center',
        ]);

        $this->actingAs($doctor)
            ->get(route('doctor.dashboard'))
            ->assertOk()
            ->assertSee('Availability & Profile', false)
            ->assertSee('Busy');
    }

    public function test_doctor_can_manage_weekly_availability_slots(): void
    {
        $this->seed(DatabaseSeeder::class);

        $doctor = User::where('email', 'michael.carter@doctor.healthcare.test')->firstOrFail();

        $this->actingAs($doctor)
            ->post(route('doctor.availability.store'), [
                'day_of_week' => 2,
                'starts_at' => '14:00',
                'ends_at' => '17:00',
            ])
            ->assertRedirect();

        $slot = $doctor->doctorProfile->availabilities()
            ->where('day_of_week', 2)
            ->where('starts_at', '14:00')
            ->firstOrFail();

        $this->assertSame('17:00', substr($slot->ends_at, 0, 5));

        $this->actingAs($doctor)
            ->delete(route('doctor.availability.destroy', $slot))
            ->assertRedirect();

        $this->assertDatabaseMissing('doctor_availabilities', [
            'id' => $slot->id,
        ]);
    }

    public function test_patient_can_update_medical_profile(): void
    {
        $this->seed(DatabaseSeeder::class);

        $patient = User::where('email', 'patient@healthcare.test')->firstOrFail();

        $this->actingAs($patient)
            ->put(route('patient.medical-profile.update'), [
                'age' => 29,
                'gender' => 'Female',
                'blood_group' => 'B+',
                'emergency_contact' => '+1 555 2222',
                'allergies' => 'Penicillin',
                'conditions' => 'Asthma',
                'medications' => 'Inhaler',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('patient_medical_profiles', [
            'user_id' => $patient->id,
            'blood_group' => 'B+',
            'allergies' => 'Penicillin',
        ]);

        $this->actingAs($patient)
            ->get(route('patient.dashboard'))
            ->assertOk()
            ->assertSee('Medical Profile')
            ->assertSee('Penicillin');
    }

    public function test_admin_can_create_update_and_delete_doctor(): void
    {
        $this->seed(DatabaseSeeder::class);
        $admin = User::where('email', 'shashwat@admin.healthcare.test')->firstOrFail();

        $this->actingAs($admin)->post(route('admin.doctors.store'), [
            'name' => 'Dr. Aditi Rao',
            'email' => 'aditi.rao@doctor.healthcare.test',
            'title' => 'Endocrinologist',
            'specialization' => 'Endocrinology',
            'experience_years' => 14,
            'rating' => 4.6,
            'review_count' => 88,
            'status' => 'Available',
            'location' => 'Care Clinic, Delhi',
            'image_path' => 'images/doctors/doctor11.png',
        ])->assertRedirect(route('admin.dashboard'));

        $profile = DoctorProfile::whereHas('user', fn ($query) => $query->where('email', 'aditi.rao@doctor.healthcare.test'))->firstOrFail();

        $this->assertDatabaseHas('doctor_profiles', [
            'user_id' => $profile->user_id,
            'specialization' => 'Endocrinology',
        ]);

        $this->actingAs($admin)->put(route('admin.doctors.update', $profile), [
            'name' => 'Dr. Aditi Rao',
            'email' => 'aditi.rao@doctor.healthcare.test',
            'title' => 'Senior Endocrinologist',
            'specialization' => 'Diabetes Care',
            'experience_years' => 15,
            'rating' => 4.8,
            'review_count' => 104,
            'status' => 'Busy',
            'location' => 'Care Clinic, Delhi',
            'image_path' => 'images/doctors/doctor11.png',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertDatabaseHas('doctor_profiles', [
            'user_id' => $profile->user_id,
            'title' => 'Senior Endocrinologist',
            'status' => 'Busy',
        ]);

        $this->actingAs($admin)->delete(route('admin.doctors.destroy', $profile))
            ->assertRedirect(route('admin.dashboard'));

        $this->assertDatabaseMissing('users', [
            'email' => 'aditi.rao@doctor.healthcare.test',
        ]);
    }

    public function test_patient_can_book_and_doctor_can_update_appointment(): void
    {
        $this->seed(DatabaseSeeder::class);

        $patient = User::where('email', 'patient@healthcare.test')->firstOrFail();
        $doctor = DoctorProfile::whereHas('user', fn ($query) => $query->where('email', 'michael.carter@doctor.healthcare.test'))->firstOrFail();

        $this->actingAs($patient)->post(route('appointments.store', $doctor), [
            'appointment_at' => now()->addWeek()->format('Y-m-d H:i:s'),
            'reason' => 'Follow up visit',
        ])->assertRedirect(route('patient.dashboard'));

        $appointment = Appointment::where('patient_id', $patient->id)
            ->where('doctor_profile_id', $doctor->id)
            ->where('reason', 'Follow up visit')
            ->firstOrFail();

        $this->assertSame('Pending', $appointment->status);

        $this->actingAs($doctor->user)->put(route('appointments.update', $appointment), [
            'status' => 'Confirmed',
            'notes' => 'Approved by doctor.',
        ])->assertRedirect();

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'Confirmed',
            'notes' => 'Approved by doctor.',
        ]);
    }

    public function test_patient_can_request_reschedule_and_doctor_can_add_prescription(): void
    {
        $this->seed(DatabaseSeeder::class);

        $patient = User::where('email', 'patient@healthcare.test')->firstOrFail();
        $appointment = Appointment::where('patient_id', $patient->id)->firstOrFail();
        $newTime = now()->addDays(8)->setTime(11, 15);

        $this->actingAs($patient)
            ->put(route('appointments.update', $appointment), [
                'reschedule_requested_at' => $newTime->format('Y-m-d H:i:s'),
                'reschedule_reason' => 'Need a later visit',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'Pending',
            'reschedule_reason' => 'Need a later visit',
        ]);

        $appointment->refresh();

        $this->actingAs($appointment->doctorProfile->user)
            ->put(route('appointments.update', $appointment), [
                'status' => 'Completed',
                'appointment_at' => $appointment->reschedule_requested_at->format('Y-m-d H:i:s'),
                'notes' => 'Visit completed.',
                'prescription' => 'Take medicine after meals.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'Completed',
            'notes' => 'Visit completed.',
            'prescription' => 'Take medicine after meals.',
            'reschedule_requested_at' => null,
            'reschedule_reason' => null,
        ]);
    }

    public function test_patient_can_book_from_doctors_directory_and_remain_signed_in(): void
    {
        $this->seed(DatabaseSeeder::class);

        $patient = User::where('email', 'patient@healthcare.test')->firstOrFail();
        $doctor = DoctorProfile::whereHas('user', fn ($query) => $query->where('email', 'sarah.johnson@doctor.healthcare.test'))->firstOrFail();
        $returnTo = route('doctors', ['from' => 'patient', 'specialization' => 'Pediatrics']);

        $this->actingAs($patient)
            ->post(route('appointments.store', $doctor), [
                'appointment_at' => now()->addDays(3)->format('Y-m-d H:i:s'),
                'reason' => 'Directory booking',
                'return_to' => $returnTo,
            ])
            ->assertRedirect($returnTo);

        $this->assertAuthenticatedAs($patient);
        $this->assertDatabaseHas('appointments', [
            'patient_id' => $patient->id,
            'doctor_profile_id' => $doctor->id,
            'reason' => 'Directory booking',
            'status' => 'Pending',
        ]);
    }
}
