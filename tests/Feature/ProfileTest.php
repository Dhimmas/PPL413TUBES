<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');
        // $response->assertOk();
        $response->assertStatus(200);
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');
        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_detail_profile_information_can_be_updated(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('profile.jpg');

        $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'gender' => 'Laki-laki',
            'tanggal_lahir' => '2002-01-01',
            'phone' => '082152257872',
            'bio' => 'Mahasiswa jurusan Sistem Informasi',
            'profile_picture' => $file,
        ]);


        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        // Cek bahwa file disimpan di storage/public (pastikan di controller kamu pakai disk 'public')
        Storage::disk('public')->assertExists('profile_pictures/' . $file->hashName());

        // Cek data user
        $user->refresh();
        $this->assertSame('Laki-laki', $user->profile->gender);
        $this->assertSame('2002-01-01', $user->profile->tanggal_lahir);
        $this->assertSame('082152257872', $user->profile->phone);
        $this->assertSame('Mahasiswa jurusan Sistem Informasi', $user->profile->bio);
    }
 
    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }
}
