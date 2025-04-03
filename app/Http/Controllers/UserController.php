<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\User\UpdateProfileRequest;

class UserController extends Controller
{
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string|in:user,admin',
        ]);

        $user->role = $request->role;
        $user->save();

        return response()->json(['message' => 'Role updated successfully']);
    }
}