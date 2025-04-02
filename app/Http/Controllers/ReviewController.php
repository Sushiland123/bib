<?php

namespace App\Http\Controllers;

    use App\Models\Review;
    use App\Models\Book;
    use Illuminate\Http\Request;
    use App\Http\Requests\Review\ReviewStoreRequest;

    class ReviewController extends Controller
    {
        public function store(ReviewStoreRequest $request, $bookId)
        {
            // Verificar si el libro existe (Opcional, pero recomendado)
            if (!Book::find($bookId)) {
                return response()->json(['message' => 'Book not found'], 404);
            }

            $review = Review::create([
                'user_id' => auth()->id(),
                'book_id' => $bookId,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'publication_date' => now(),
            ]);

            return response()->json($review, 201);
        }

        public function index($bookId)
        {
            // Verificar si el libro existe (Opcional, pero recomendado)
            if (!Book::find($bookId)) {
                return response()->json(['message' => 'book not found'], 404);
            }

            $reviews = Review::where('book_id', $bookId)->get();

            return response()->json($reviews, 200);
        }
    }
