<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $fillable = [
        'title', 'edition', 'copyright', 'language', 'pages',
        'autor_id', 'editorial_id'
    ];

    public function autor()
    {
        return $this->belongsTo(Autor::class, 'autor_id');
    }

    public function editorial()
    {
        return $this->belongsTo(Editorial::class, 'editorial_id');
    }
}
