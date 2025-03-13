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

        // Perfil de Usuario
        Route::get('/profile/user', [UserController::class, 'profile'])->middleware('auth:sanctum');
        Route::put('/profile/user', [UserController::class, 'updateProfile'])->middleware('auth:sanctum');

        // Libros
        Route::get('/books', [BookController::class, 'index']);
        Route::post('/books', [BookController::class, 'store'])->middleware('auth:sanctum');
        Route::put('/books/{book}', [BookController::class, 'update'])->middleware('auth:sanctum');
        Route::delete('/books/{book}', [BookController::class, 'destroy'])->middleware('auth:sanctum');

        // Biblioteca Personal
        Route::post('/library', [PersonalLibraryController::class, 'store'])->middleware('auth:sanctum');

        // Reseñas
        Route::post('/books/{bookId}/reviews', [ReviewController::class, 'store'])->middleware('auth:sanctum');
        Route::get('/books/{bookId}/reviews', [ReviewController::class, 'index']);
    });