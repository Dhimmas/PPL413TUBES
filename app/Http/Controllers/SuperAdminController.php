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
            return response()->json(['error' => 'Cannot modify your own admin status'], 400);
        }

        // Check if user is super admin - super admin can't be changed to regular admin
        if ($user->is_super_admin) {
            return response()->json(['error' => 'Cannot modify super admin status'], 400);
        }

        $oldStatus = $user->is_admin;
        $user->update([
            'is_admin' => !$user->is_admin
        ]);

        $action = $user->is_admin ? 'promoted to' : 'removed from';
        $message = "User {$user->name} has been {$action} Admin successfully";

        return response()->json([
            'success' => true,
            'message' => $message,
            'is_admin' => $user->is_admin,
            'user_name' => $user->name,
            'old_status' => $oldStatus,
            'new_status' => $user->is_admin
        ]);
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return response()->json(['error' => 'Cannot delete your own account'], 400);
        }

        $userName = $user->name;
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => "User {$userName} has been deleted successfully",
            'deleted_user_name' => $userName
        ]);
    }
}
