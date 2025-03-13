<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
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
            'titulo' => 'string|max:255',
            'editorial' => 'string|max:255',
            'ISBN' => 'string|max:255',
            'idioma' => 'string|max:255',
            'edicion' => 'string|max:255',
            'autor' => 'string|max:255',
            'descripcion' => 'string',
            'año_publicacion' => 'integer',
            'categoria' => 'string|max:255',
        ];
    }
}