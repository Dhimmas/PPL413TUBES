<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProfileTest2 extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_returns_200_for_authenticated_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile');

        $response->assertStatus(200);
    }


    public function test_profile_page_redirects_guest_to_login()
    {
        $response = $this->get('/profile');

        $response->assertRedirect('/login');
    }



    
}