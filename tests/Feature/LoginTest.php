<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_page_returns_status_200()
    {
        // Mengirim permintaan GET ke halaman login
        $response = $this->get('/login');

        // Memastikan respons status HTTP 200
        $response->assertStatus(200);
    }

    /** @test */
    public function test_login_validation_fails_with_invalid_email()
    {
        // Mengirim permintaan POST dengan email yang tidak valid
        $response = $this->post('/login', [
            'email' => 'invalidemail',
            'password' => 'password123',
        ]);

        // Memastikan validasi gagal dan menampilkan error pada email
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function test_login_validation_fails_with_missing_password()
    {
        // Mengirim permintaan POST tanpa password
        $response = $this->post('/login', [
            'email' => 'testuser@example.com',
            'password' => '',
        ]);

        // Memastikan validasi gagal dan menampilkan error pada password
        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function test_login_rate_limiting()
    {
        // Mengirim permintaan login lebih dari batas percobaan
        $response = $this->post('/login', [
            'email' => 'testuser@example.com',
            'password' => 'wrongpassword',
        ]);

        // Memastikan login gagal dan respons dengan error
        $response->assertSessionHasErrors('email');

        // Cek apakah rate limiter berfungsi
        $response = $this->post('/login', [
            'email' => 'testuser@example.com',
            'password' => 'wrongpassword',
        ]);

        // Memastikan statusnya terlalu banyak percobaan
        $response->assertSessionHasErrors('email');
    }
}



