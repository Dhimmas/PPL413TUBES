<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterPageTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function register_page_is_accessible()
    {
        $response = $this->get(route('register'));
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_register()
    {
        $response = $this->post(route('register'), [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'agree' => 'on',
        ]);

        $response->assertRedirect(route('login'));

        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com',
        ]);
    }
}
