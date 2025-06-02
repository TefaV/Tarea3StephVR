<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    protected $fillable = [
        'publisher', 'country', 'founded', 'genre'
    ];

    public function libros()
    {
        return $this->hasMany(Libro::class, 'editorial_id');
    }
}
