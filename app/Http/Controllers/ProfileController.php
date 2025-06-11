<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Controllers\UserQuizController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    protected $userQuizController;

    public function __construct(UserQuizController $userQuizController)
    {
        $this->userQuizController = $userQuizController;
    }

    /**
     * Display the user's profile.
     */
    public function show(Request $request): View
    {
        $user = $request->user()->load('profile');
        
        // Mendapatkan statistik activity menggunakan UserQuizController
        $activityData = $this->userQuizController->getUserActivityOverview($user);
        
        // Mendapatkan statistik forum posts
        $forumPostsCount = $user->forumPosts()->count();
        
        return view('profile.show', [
            'user' => $user,
            'quizStats' => $activityData['quizStats'],
            'forumPostsCount' => $forumPostsCount,
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Mendapatkan statistik quiz activity menggunakan UserQuizController
        $activityData = $this->userQuizController->getUserActivityOverview($user);
        
        return view('profile.edit', [
            'user' => $user,
            'quizStats' => $activityData['quizStats'],
            'uncompletedQuizzes' => $activityData['uncompletedQuizzes']
        ]);
    }

    /**
     * Store or update profile details.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'gender' => ['nullable', 'in:Laki-laki,Perempuan'],
            'tanggal_lahir' => ['nullable', 'date'],
            'phone' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
        ]);

        $user = $request->user();
        $profile = $user->profile;

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($profile && $profile->profile_picture) {
                Storage::disk('public')->delete($profile->profile_picture);
            }
            
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        if ($profile) {
            // Update existing profile - only update fields that are provided
            $updateData = array_filter($validated, function($value) {
                return $value !== null;
            });
            $profile->update($updateData);
        } else {
            // Create new profile
            $validated['user_id'] = $user->id;
            Profile::create($validated);
        }
        
        return Redirect::route('profile.edit')->with('status', 'profile-detail-updated');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
