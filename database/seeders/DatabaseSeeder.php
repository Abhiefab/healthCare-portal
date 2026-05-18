<?php

namespace Database\Seeders;

use App\Models\DoctorProfile;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminUsers = [
            [
                'name' => 'Avinash',
                'email' => 'avinash@admin.healthcare.test',
            ],
            [
                'name' => 'Shashwat',
                'email' => 'shashwat@admin.healthcare.test',
            ],
            [
                'name' => 'Zaid',
                'email' => 'zaid@admin.healthcare.test',
            ],
        ];

        foreach ($adminUsers as $adminUser) {
            User::updateOrCreate(
                ['email' => $adminUser['email']],
                [
                    'name' => $adminUser['name'],
                    'password' => Hash::make('Admin@12345'),
                    'role' => 'admin',
                ],
            );
        }

        $doctors = [
            [
                'name' => 'Dr. Michael Carter',
                'email' => 'michael.carter@doctor.healthcare.test',
                'title' => 'Orthopedic Surgeon',
                'specialization' => 'Orthopedics',
                'experience_years' => 12,
                'rating' => 4.9,
                'review_count' => 230,
                'location' => 'Main Clinic, New York',
                'image_path' => 'images/doctors/doctor5.png',
            ],
            [
                'name' => 'Dr. Sarah Johnson',
                'email' => 'sarah.johnson@doctor.healthcare.test',
                'title' => 'Pediatric Specialist',
                'specialization' => 'Pediatrics',
                'experience_years' => 8,
                'rating' => 4.8,
                'review_count' => 185,
                'location' => 'Kids Care Clinic, Boston',
                'image_path' => 'images/doctors/doctor7.png',
            ],
            [
                'name' => 'Dr. David Wilson',
                'email' => 'david.wilson@doctor.healthcare.test',
                'title' => 'Cardiologist',
                'specialization' => 'Cardiology',
                'experience_years' => 15,
                'rating' => 4.9,
                'review_count' => 210,
                'location' => 'Heart Care Center, Chicago',
                'image_path' => 'images/doctors/doctor6.png',
            ],
            [
                'name' => 'Dr. Emily Brown',
                'email' => 'emily.brown@doctor.healthcare.test',
                'title' => 'Dermatologist',
                'specialization' => 'Dermatology',
                'experience_years' => 9,
                'rating' => 4.7,
                'review_count' => 160,
                'location' => 'Skin Health Clinic, California',
                'image_path' => 'images/doctors/doctor9.png',
            ],
            [
                'name' => 'Dr. Olivia Martinez',
                'email' => 'olivia.martinez@doctor.healthcare.test',
                'title' => 'Neurologist',
                'specialization' => 'Neurology',
                'experience_years' => 11,
                'rating' => 4.8,
                'review_count' => 198,
                'location' => 'Neuro Care Institute, Boston',
                'image_path' => 'images/doctors/doctor3.png',
            ],
            [
                'name' => 'Dr. James Anderson',
                'email' => 'james.anderson@doctor.healthcare.test',
                'title' => 'Psychiatrist',
                'specialization' => 'Psychiatry',
                'experience_years' => 13,
                'rating' => 4.9,
                'review_count' => 144,
                'location' => 'Mind Wellness Center, Seattle',
                'image_path' => 'images/doctors/doctor2.jpg',
            ],
            [
                'name' => 'Dr. Sophia Lee',
                'email' => 'sophia.lee@doctor.healthcare.test',
                'title' => 'Gynecologist',
                'specialization' => 'Gynecology',
                'experience_years' => 10,
                'rating' => 4.8,
                'review_count' => 176,
                'location' => "Women's Health Center, Miami",
                'image_path' => 'images/doctors/doctor13.png',
            ],
            [
                'name' => 'Dr. Ethan Walker',
                'email' => 'ethan.walker@doctor.healthcare.test',
                'title' => 'General Physician',
                'specialization' => 'General Medicine',
                'experience_years' => 7,
                'rating' => 4.7,
                'review_count' => 132,
                'location' => 'City Medical Hospital, Texas',
                'image_path' => 'images/doctors/doctor10.png',
            ],
        ];

        foreach ($doctors as $doctor) {
            $user = User::updateOrCreate(
                ['email' => $doctor['email']],
                [
                    'name' => $doctor['name'],
                    'password' => Hash::make('Doctor@12345'),
                    'role' => 'doctor',
                ],
            );

            DoctorProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'title' => $doctor['title'],
                    'specialization' => $doctor['specialization'],
                    'experience_years' => $doctor['experience_years'],
                    'rating' => $doctor['rating'],
                    'review_count' => $doctor['review_count'],
                    'status' => 'Available',
                    'location' => $doctor['location'],
                    'image_path' => $doctor['image_path'],
                ],
            );
        }

        $patient = User::updateOrCreate(
            ['email' => 'patient@healthcare.test'],
            [
                'name' => 'Demo Patient',
                'password' => Hash::make('Patient@12345'),
                'role' => 'patient',
            ],
        );

        $firstDoctor = DoctorProfile::whereHas('user', fn ($query) => $query->where('email', 'michael.carter@doctor.healthcare.test'))->first();
        $secondDoctor = DoctorProfile::whereHas('user', fn ($query) => $query->where('email', 'sarah.johnson@doctor.healthcare.test'))->first();

        if ($firstDoctor) {
            Appointment::updateOrCreate(
                [
                    'patient_id' => $patient->id,
                    'doctor_profile_id' => $firstDoctor->id,
                    'appointment_at' => now()->addDays(2)->setTime(10, 30),
                ],
                [
                    'reason' => 'Knee pain consultation',
                    'status' => 'Confirmed',
                    'notes' => 'Bring previous scan reports.',
                ],
            );
        }

        if ($secondDoctor) {
            Appointment::updateOrCreate(
                [
                    'patient_id' => $patient->id,
                    'doctor_profile_id' => $secondDoctor->id,
                    'appointment_at' => now()->addDays(4)->setTime(15, 0),
                ],
                [
                    'reason' => 'General child wellness advice',
                    'status' => 'Pending',
                    'notes' => null,
                ],
            );
        }
    }
}
