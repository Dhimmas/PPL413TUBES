<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function dashboard_page_is_accessible_for_authenticated_users()
    {
        // Arrange: buat user
        $user = \App\Models\User::factory()->create();  

        // Act: login dan akses halaman dashboard
        $response = $this->actingAs($user)->get('/');

        $response->dump(); // Tambahkan ini untuk menampilkan error detail saat test
        
        // Assert: pastikan halaman bisa diakses (status 200)
        $response->assertStatus(200);
    }

    /** @test */
    public function dashboard_page_redirects_unauthenticated_users()
    {
        // Akses halaman dashboard tanpa login
        $response = $this->get('/');

        // Harus redirect ke login
        $response->assertRedirect('/login');
    }
}
