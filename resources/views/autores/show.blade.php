@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Autor: {{ $autor->author }}</h1>

    <p><strong>Nacionalidad:</strong> {{ $autor->nationality }}</p>
    <p><strong>Año de nacimiento:</strong> {{ $autor->birth_year }}</p>
    <p><strong>Campos:</strong> {{ $autor->fields }}</p>

    <h2 class="text-xl font-semibold mt-6 mb-2">Libros escritos:</h2>
    <ul class="list-disc pl-5">
        @foreach ($autor->libros as $libro)
            <li>
                <a href="{{ route('libros.show', $libro) }}" class="text-blue-600 hover:underline">
                    {{ $libro->title }} ({{ $libro->edition }})
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
