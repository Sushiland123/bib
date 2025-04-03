<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PersonalLibraryController;
use App\Http\Controllers\ReviewController;

Route::middleware('api')->prefix('v1')->group(function () {
    // Autenticación
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    // otorgar privilegios de administrador
    Route::post('/auth/admin/{userId}', [AuthController::class, 'grantAdminPrivileges'])->middleware('role:admin');
    // revocar privilegios de administrador
    Route::delete('/auth/admin/{userId}', [AuthController::class, 'revokeAdminPrivileges'])->middleware('role:admin');
    // Obtener todos los usuarios
    Route::get('/auth/users', [AuthController::class, 'index'])->middleware('role:admin');
    // Obtener usuario por id
    Route::get('/auth/users/{userId}', [AuthController::class, 'show'])->middleware('role:admin');

    // Perfil de Usuario
    Route::get('/profile/user', [UserController::class, 'profile'])->middleware('auth:sanctum');
    Route::put('/profile/user', [UserController::class, 'updateProfile'])->middleware('auth:sanctum');

    // Libros
    Route::get('/books', [BookController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/books', [BookController::class, 'store'])->middleware('role:admin');
    Route::put('/books/{book}', [BookController::class, 'update'])->middleware('role:admin');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->middleware('role:admin');

    // Agregar libro a la biblioteca personal
    Route::post('/library/{bookId}', [PersonalLibraryController::class, 'addBook'])->middleware('auth:sanctum');
    // Eliminar libro de la biblioteca personal
    Route::delete('/library/{bookId}', [PersonalLibraryController::class, 'destroy'])->middleware('auth:sanctum');
    // Obtener libros de la biblioteca personal
    Route::get('/library', [PersonalLibraryController::class, 'index'])->middleware('auth:sanctum');
    // Obtener libros de la biblioteca personal por id
    Route::get('/library/{bookId}', [PersonalLibraryController::class, 'show'])->middleware('auth:sanctum');

    // Reseñas
    Route::post('/books/{bookId}/reviews', [ReviewController::class, 'store'])->middleware('auth:sanctum');
    Route::get('/books/{bookId}/reviews', [ReviewController::class, 'index'])->middleware('auth:sanctum');
});