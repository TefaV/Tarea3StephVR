@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">📚 Lista de Libros</h1>
            <a href="{{ route('libros.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                ➕ Agregar Libro
            </a>
        </div>

        @forelse ($libros as $libro)
            <div class="bg-white border-l-4 border-blue-500 shadow-md rounded p-4 mb-4">
                <h2 class="text-xl font-semibold text-blue-800">{{ $libro->title }} <span class="text-sm text-gray-600">({{ $libro->edition }})</span></h2>

                <p><strong>🖋 Autor:</strong>
                    @if($libro->autor)
                        <a href="{{ route('autors.show', $libro->autor->id) }}" class="text-indigo-600 hover:underline font-medium">
                            {{ $libro->autor->author }}
                        </a>
                    @else
                        <span class="text-gray-500">Desconocido</span>
                    @endif
                </p>

                <p><strong>🏢 Editorial:</strong>
                    @if($libro->editorial)
                        <a href="{{ route('editorials.show', $libro->editorial->id) }}" class="text-indigo-600 hover:underline font-medium">
                            {{ $libro->editorial->publisher }}
                        </a>
                    @else
                        <span class="text-gray-500">Desconocida</span>
                    @endif
                </p>

                <p><strong>📅 Año:</strong> {{ $libro->copyright }}</p>
                <p><strong>📖 Páginas:</strong> {{ $libro->pages }}</p>
                <p><strong>🗣 Idioma:</strong> {{ $libro->language }}</p>

                <div class="mt-4 flex gap-2">
                    <a href="{{ route('libros.edit', $libro->id) }}" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 transition">
                        ✏️ Editar
                    </a>

                    <form action="{{ route('libros.destroy', $libro->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este libro?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                            🗑 Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-600">No hay libros disponibles.</p>
        @endforelse
    </div>
@endsection
