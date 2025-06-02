<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Autor;
use App\Models\Editorial;
use App\Models\Libro;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $autor1 = Autor::create([
            'author' => 'Abraham Silberschatz',
            'nationality' => 'Israelis / American',
            'birth_year' => 1952,
            'fields' => 'Database Systems, Operating Systems',
        ]);

        $autor2 = Autor::create([
            'author' => 'Andrew S. Tanenbaum',
            'nationality' => 'Dutch / American',
            'birth_year' => 1944,
            'fields' => 'Distributed computing, Operating Systems',
        ]);

        $editorial1 = Editorial::create([
            'publisher' => 'John Wiley & Sons',
            'country' => 'United States',
            'founded' => 1807,
            'genre' => 'Academic',
        ]);

        $editorial2 = Editorial::create([
            'publisher' => 'Pearson Education',
            'country' => 'United Kingdom',
            'founded' => 1844,
            'genre' => 'Education',
        ]);

        Libro::create([
            'title' => 'Operating System Concepts',
            'edition' => '9th',
            'copyright' => 2012,
            'language' => 'ENGLISH',
            'pages' => 976,
            'autor_id' => $autor1->id,
            'editorial_id' => $editorial1->id,
        ]);

        Libro::create([
            'title' => 'Database System Concepts',
            'edition' => '6th',
            'copyright' => 2010,
            'language' => 'ENGLISH',
            'pages' => 1376,
            'autor_id' => $autor1->id,
            'editorial_id' => $editorial1->id,
        ]);

        Libro::create([
            'title' => 'Computer Networks',
            'edition' => '5th',
            'copyright' => 2010,
            'language' => 'ENGLISH',
            'pages' => 960,
            'autor_id' => $autor2->id,
            'editorial_id' => $editorial2->id,
        ]);

        Libro::create([
            'title' => 'Modern Operating Systems',
            'edition' => '4th',
            'copyright' => 2014,
            'language' => 'ENGLISH',
            'pages' => 1136,
            'autor_id' => $autor2->id,
            'editorial_id' => $editorial2->id,
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('user'),
        ]);
    }
}
