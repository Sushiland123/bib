<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'editorial',
        'ISBN',
        'idioma',
        'edicion',
        'autor',
        'descripcion',
        'año_publicacion',
        'categoria',
    ];

    /**
     * Get the users who have this book in their personal library.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'personal_libraries', 'book_id', 'user_id');
    }

    /**
     * Get the reviews for the book.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'id_libro');
    }
}