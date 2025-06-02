@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Editar Libro</h1>

    <form action="{{ route('libros.update', $libro->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium">Título</label>
            <input type="text" name="title" value="{{ old('title', $libro->title) }}" class="w-full border px-4 py-2 rounded">
        </div>

        <div>
            <label class="block font-medium">Edición</label>
            <input type="text" name="edition" value="{{ old('edition', $libro->edition) }}" class="w-full border px-4 py-2 rounded">
        </div>

        <div>
            <label class="block font-medium">Año</label>
            <input type="number" name="copyright" value="{{ old('copyright', $libro->copyright) }}" class="w-full border px-4 py-2 rounded">
        </div>

        <div>
            <label class="block font-medium">Páginas</label>
            <input type="number" name="pages" value="{{ old('pages', $libro->pages) }}" class="w-full border px-4 py-2 rounded">
        </div>

        <div>
            <label class="block font-medium">Idioma</label>
            <input type="text" name="language" value="{{ old('language', $libro->language) }}" class="w-full border px-4 py-2 rounded">
        </div>

        <div>
            <label class="block font-medium">Autor</label>
            <select name="author_id" class="w-full border px-4 py-2 rounded">
                @foreach($autores as $autor)
                    <option value="{{ $autor->id }}" {{ $libro->author_id == $autor->id ? 'selected' : '' }}>
                        {{ $autor->author }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium">Editorial</label>
            <select name="publisher_id" class="w-full border px-4 py-2 rounded">
                @foreach($editoriales as $editorial)
                    <option value="{{ $editorial->id }}" {{ $libro->publisher_id == $editorial->id ? 'selected' : '' }}>
                        {{ $editorial->publisher }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Actualizar</button>
        <a href="{{ route('dashboard') }}" class="ml-4 text-gray-600 underline">Cancelar</a>
    </form>
</div>
@endsection
