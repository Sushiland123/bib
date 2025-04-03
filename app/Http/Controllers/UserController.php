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
        public function profile()
        {
            return response()->json(auth()->user(), 200);
        }
    
        public function updateProfile(UpdateProfileRequest $request)
        {
            $user = auth()->user();
    
            $user->update($request->only('name', 'age', 'country', 'username'));
    
            return response()->json(['message' => 'Profile successfuly'], 200);
        }
}