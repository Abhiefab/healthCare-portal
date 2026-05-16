<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_is_sent_to_role_dashboard_placeholder(): void
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

    public function test_login_redirects_by_role_to_dashboard_placeholder(): void
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

    public function test_seeded_admin_can_login_to_admin_dashboard_placeholder(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->post('/login', [
            'email' => 'shashwat@admin.healthcare.test',
            'password' => 'Admin@12345',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }
}
