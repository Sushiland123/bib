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

        $user->update($request->only('nombre', 'edad', 'país', 'nombreUsuario'));

        return response()->json(['message' => 'Perfil actualizado correctamente'], 200);
    }
}