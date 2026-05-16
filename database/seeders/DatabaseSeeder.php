<?php

namespace Database\Seeders;

use App\Models\User;
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
    }
}
