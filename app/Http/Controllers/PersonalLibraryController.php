<?php

namespace App\Http\Controllers;

use App\Models\PersonalLibrary;
use Illuminate\Http\Request;
use App\Models\Book;

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
    }

    public function index()
    {
        $user = auth()->user();
        $books = $user->books;

        return response()->json($books, 200);
    }

    public function destroy($bookId)
    {
        $user = auth()->user();

        // Verificar si el libro existe en la biblioteca del usuario
        if (!$user->books()->where('book_id', $bookId)->exists()) {
            return response()->json(['message' => 'Libro no encontrado en tu biblioteca'], 404);
        }

        $user->books()->detach($bookId);

        return response()->json(['message' => 'Libro eliminado de tu biblioteca'], 200);
    }
}