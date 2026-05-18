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

    public function test_patient_and_doctor_dashboards_require_authentication(): void
    {
        $this->get(route('patient.dashboard'))->assertRedirect(route('login'));
        $this->get(route('doctor.dashboard'))->assertRedirect(route('login'));
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
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
            ->assertSee('Dr. Sarah Johnson');
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
}
