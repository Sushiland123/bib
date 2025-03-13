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
            'titulo' => 'required|string|max:255',
            'editorial' => 'required|string|max:255',
            'ISBN' => 'required|string|max:255',
            'idioma' => 'required|string|max:255',
            'edicion' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'año_publicacion' => 'required|integer',
            'categoria' => 'required|string|max:255',
        ];
    }
}