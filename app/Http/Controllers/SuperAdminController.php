<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('super-admin.index', compact('users'));
    }

    public function toggleSuperAdmin(User $user)
    {
        if ($user->id === Auth::id()) {
            return response()->json(['error' => 'Cannot modify your own super admin status'], 400);
        }

        $user->update([
            'is_super_admin' => !$user->is_super_admin
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully',
            'is_super_admin' => $user->is_super_admin
        ]);
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return response()->json(['error' => 'Cannot delete your own account'], 400);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}
