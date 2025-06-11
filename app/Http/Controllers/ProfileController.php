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
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'gender' => ['nullable', 'in:Laki-laki,Perempuan'],
            'tanggal_lahir' => ['nullable', 'date'],
            'phone' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'current_password' => ['nullable', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();
        $profile = $user->profile;

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($profile && $profile->profile_picture) {
                \Storage::disk('public')->delete($profile->profile_picture);
            }
            
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        // Update user data only if provided
        $userUpdateData = [];
        if (!empty($validated['name'])) {
            $userUpdateData['name'] = $validated['name'];
        }
        if (!empty($validated['email']) && $validated['email'] !== $user->email) {
            // Check if email is unique
            $existingUser = \App\Models\User::where('email', $validated['email'])->where('id', '!=', $user->id)->first();
            if ($existingUser) {
                return back()->withErrors(['email' => 'Email sudah digunakan oleh pengguna lain.'])->withInput();
            }
            $userUpdateData['email'] = $validated['email'];
            $userUpdateData['email_verified_at'] = null; // Reset email verification if email changed
        }

        // Update password if provided
        if (!empty($validated['current_password']) && !empty($validated['password'])) {
            if (!\Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])->withInput();
            }
            $userUpdateData['password'] = \Hash::make($validated['password']);
        }

        // Update user data if there are changes
        if (!empty($userUpdateData)) {
            $user->update($userUpdateData);
        }

        // Prepare profile data
        $profileData = [];
        if (isset($validated['profile_picture'])) {
            $profileData['profile_picture'] = $validated['profile_picture'];
        }
        if (isset($validated['gender'])) {
            $profileData['gender'] = $validated['gender'];
        }
        if (isset($validated['tanggal_lahir'])) {
            $profileData['tanggal_lahir'] = $validated['tanggal_lahir'];
        }
        if (isset($validated['phone'])) {
            $profileData['phone'] = $validated['phone'];
        }
        if (isset($validated['bio'])) {
            $profileData['bio'] = $validated['bio'];
        }

        // Update or create profile only if there are changes
        if (!empty($profileData)) {
            if ($profile) {
                $profile->update($profileData);
            } else {
                $profileData['user_id'] = $user->id;
                \App\Models\Profile::create($profileData);
            }
        }
        
        return redirect()->route('profile.edit')->with('status', 'profile-detail-updated');
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
