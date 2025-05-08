<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'gender' => 'required',
            'tanggal_lahir' => 'required|date',
            'phone' => 'required|string',
            'bio' => 'nullable|string',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id(); // penting

        // Handle upload profile picture (jika ada)
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
        
            if ($file->isValid()) {
                $path = $file->store('profile_pictures', 'public'); // Simpan gambar di folder 'public/profile_pictures'
                $data['profile_picture'] = $path; // Simpan path gambar
            } else {
                return back()->withErrors(['profile_picture' => 'File upload gagal, file tidak valid.']);
            }
        }
        // Simpan profile baru
        Profile::create($data);

        return back()->with('status', 'profile-detail-updated');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Update data dari tabel users
        $user->fill($request->only(['name', 'email']));
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();

        // Update atau create data dari tabel profiles
        $dataProfile = $request->only(['tanggal_lahir', 'gender', 'phone', 'bio']);

        // Handle upload profile picture (jika ada)
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
        
            if ($file->isValid()) {
                $path = $file->store('profile_pictures', 'public');
                $dataProfile['profile_picture'] = $path;
            } else {
                return back()->withErrors(['profile_picture' => 'File upload gagal, file tidak valid.']);
            }
        } else {
            // Jangan menimpa field profile_picture jika tidak ada file baru
            unset($dataProfile['profile_picture']);
        }

        // Update atau create data profil pengguna
        $user->profile()->updateOrCreate(['user_id' => $user->id], $dataProfile);

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
