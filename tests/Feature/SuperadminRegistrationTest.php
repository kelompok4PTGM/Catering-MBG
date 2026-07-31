<?php

namespace Tests\Feature;

use Tests\TestCase;

class SuperadminRegistrationTest extends TestCase
{
    public function test_user_can_register_as_superadmin(): void
    {
        $response = $this->post('/register', [
            'username' => 'superadmin2',
            'email' => 'superadmin2@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'Superadmin',
        ]);

        $response->assertRedirect('/dashboard');

        $this->assertDatabaseHas('pengguna', [
            'username' => 'superadmin2',
            'role' => 'Superadmin',
        ]);
    }
}
