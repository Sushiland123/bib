<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'age' => $request->age,
            'country' => $request->country,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'invalid credentials'], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'You are logged out'], 200);
    }

    public function grantAdminPrivileges($userId)
    {
        $user = User::findOrFail($userId);
        $user->role = 'admin';
        $user->save();

        return response()->json(['message' => 'Admin privileges granted'], 200);
    }

    public function revokeAdminPrivileges($userId)
    {
        $user = User::findOrFail($userId);
        $user->role = 'user';
        $user->save();

        return response()->json(['message' => 'Admin privileges revoked'], 200);
    }

    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    public function show($userId)
    {
        $user = User::findOrFail($userId);
        return response()->json($user, 200);
    }
}