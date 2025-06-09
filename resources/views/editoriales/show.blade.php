@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Editorial: {{ $editorial->publisher }}</h1>

    <p><strong>País:</strong> {{ $editorial->country }}</p>
    <p><strong>Año de fundación:</strong> {{ $editorial->founded }}</p>
    <p><strong>Género:</strong> {{ $editorial->genere }}</p>

    <h2 class="text-xl font-semibold mt-6 mb-2">Libros publicados:</h2>
    <ul class="list-disc pl-5">
        @foreach ($editorial->libros as $libro)
            <li>
                <a href="{{ route('libros.show', $libro) }}" class="text-blue-600 hover:underline">
                    {{ $libro->title }} ({{ $libro->edition }})
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
