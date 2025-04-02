<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\User\UpdateProfileRequest;

class UserController extends Controller
{
    public function profile()
    {
        return response()->json(auth()->user(), 200);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = auth()->user();

        $user->update($request->only('name', 'age', 'country', 'username'));

        return response()->json(['message' => 'Profile successfuly updated'], 200);
    }
}