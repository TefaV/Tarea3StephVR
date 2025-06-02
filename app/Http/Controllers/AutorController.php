<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    // Mostrar lista de autores con sus libros
    public function index()
    {
        $autores = Autor::with('libros')->paginate(10);
        return view('autores.index', compact('autores'));
    }

    // Mostrar formulario para crear un nuevo autor
    public function create()
    {
        return view('autores.create');
    }

    // Guardar un nuevo autor
    public function store(Request $request)
    {
        $request->validate([
            'author' => 'required',
            'nationality' => 'required',
            'birth_year' => 'required|integer',
            'fields' => 'required',
        ]);

        Autor::create($request->all());

        return redirect()->route('autores.index')->with('success', 'Autor creado correctamente.');
    }

    // Mostrar un autor específico
    public function show(Autor $autor)
    {
        return view('autores.show', compact('autor'));
    }

    // Mostrar formulario de edición
    public function edit(Autor $autor)
    {
        return view('autores.edit', compact('autor'));
    }

    // Actualizar un autor
    public function update(Request $request, Autor $autor)
    {
        $request->validate([
            'author' => 'required',
            'nationality' => 'required',
            'birth_year' => 'required|integer',
            'fields' => 'required',
        ]);

        $autor->update($request->all());

        return redirect()->route('autores.index')->with('success', 'Autor actualizado correctamente.');
    }

    // Eliminar un autor
    public function destroy(Autor $autor)
    {
        $autor->delete();

        return redirect()->route('autores.index')->with('success', 'Autor eliminado correctamente.');
    }
}
