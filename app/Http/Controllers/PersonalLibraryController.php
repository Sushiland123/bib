<?php

namespace App\Http\Controllers;

    use App\Models\PersonalLibrary;
    use Illuminate\Http\Request;

    class PersonalLibraryController extends Controller
    {
        public function store(Request $request)
{
    $user = auth()->user();
    $bookId = $request->query('id');

    // Validar que el 'id' está presente y es un entero positivo
    $request->validate([
        'id' => 'required|integer|min:1',
    ]);

    // Verificar si el libro existe (Opcional, pero recomendado)
    if (!Book::find($bookId)) {
        return response()->json(['message' => 'Libro no encontrado'], 404);
    }

    // Verificar si el libro ya está en la biblioteca del usuario (Opcional)
    if ($user->books()->where('book_id', $bookId)->exists()) {
        return response()->json(['message' => 'El libro ya está en tu biblioteca'], 409);
    }

    $user->books()->attach($bookId);

    return response()->json(['message' => 'Libro agregado correctamente'], 200);
}}