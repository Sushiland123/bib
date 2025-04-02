<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'tittle' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'ISBN' => 'required|string|max:255',
            'lenguage' => 'required|string|max:255',
            'version' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'publication_date' => 'required|integer',
            'categories' => 'required|string|max:255',
        ];
    }
}