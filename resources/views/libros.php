@extends('layouts.app')

@section('content')
<h1>Libros</h1>
<a href="{{ route('libros.create') }}">Agregar Libro</a>
<table>
<thead>
<tr>
<th>Título</th><th>Autor</th><th>Editorial</th><th>Acciones</th>
</tr>
</thead>
<tbody>
@foreach($libros as $libro)
<tr>
    <td><a href="{{ route('libros.show', $libro) }}">{{ $libro->title }}</a></td>
    <td><a href="{{ route('autors.show', $libro->autor) }}">{{ $libro->autor->author }}</a></td>
    <td><a href="{{ route('editorials.show', $libro->editorial) }}">{{ $libro->editorial->publisher }}</a></td>
    <td>
        <a href="{{ route('libros.edit', $libro) }}">Editar</a>
        <form action="{{ route('libros.destroy', $libro) }}" method="POST" style="display:inline">
            @csrf @method('DELETE')
            <button type="submit" onclick="return confirm('¿Eliminar libro?')">Eliminar</button>
        </form>
    </td>
</tr>
@endforeach
</tbody>
</table>
{{ $libros->links() }}
@endsection
