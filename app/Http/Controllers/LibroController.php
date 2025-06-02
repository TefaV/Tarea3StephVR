<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Autor;
use App\Models\Editorial;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    // Mostrar listado de libros con relaciones
    public function index()
    {
        $libros = Libro::with(['autor', 'editorial'])->paginate(10);
        return view('libros.index', compact('libros'));
    }

    // Mostrar formulario para crear un nuevo libro
    public function create()
    {
        $autores = Autor::all();
        $editoriales = Editorial::all();
        return view('libros.create', compact('autores', 'editoriales'));
    }

    // Guardar nuevo libro en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'edition' => 'required',
            'copyright' => 'required',
            'language' => 'required',
            'pages' => 'required|integer',
            'autor_id' => 'required|exists:autores,id',
            'editorial_id' => 'required|exists:editoriales,id',
        ]);

        Libro::create($request->all());

        return redirect()->route('libros.index')->with('success', 'Libro creado correctamente.');
    }

    // Mostrar detalles de un libro
    public function show(Libro $libro)
    {
        return view('libros.show', compact('libro'));
    }

    // Mostrar formulario para editar libro existente
    public function edit(Libro $libro)
    {
        $autores = Autor::all();
        $editoriales = Editorial::all();
        return view('libros.edit', compact('libro', 'autores', 'editoriales'));
    }

    // Actualizar información de un libro
    public function update(Request $request, Libro $libro)
    {
        $request->validate([
            'title' => 'required',
            'edition' => 'required',
            'copyright' => 'required',
            'language' => 'required',
            'pages' => 'required|integer',
            'autor_id' => 'required|exists:autores,id',
            'editorial_id' => 'required|exists:editoriales,id',
        ]);

        $libro->update($request->all());

        return redirect()->route('libros.index')->with('success', 'Libro actualizado correctamente.');
    }

    // Eliminar libro
    public function destroy(Libro $libro)
    {
        $libro->delete();

        return redirect()->route('libros.index')->with('success', 'Libro eliminado correctamente.');
    }
}
