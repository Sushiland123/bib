<?php

namespace App\Http\Controllers;

    use App\Models\Book;
    use Illuminate\Http\Request;
    use App\Http\Requests\Book\BookStoreRequest;
    use App\Http\Requests\Book\BookUpdateRequest;

    class BookController extends Controller
    {
        public function index(Request $request)
        {
            $query = Book::query();

            if ($request->has('categoria')) {
                $query->where('categoria', $request->categoria);
            }

            $books = $query->get();

            return response()->json($books, 200);
        }

        public function store(BookStoreRequest $request)
        {
            $book = Book::create($request->all());

            return response()->json($book, 201);
        }

        public function update(BookUpdateRequest $request, Book $book)
        {
            $book->update($request->all());

            return response()->json($book, 200);
        }

        public function destroy(Book $book)
        {
            $book->delete();

            return response()->json(['message' => 'Libro eliminado correctamente'], 200);
        }
    }