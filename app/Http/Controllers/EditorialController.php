<?php

namespace App\Http\Controllers;

use App\Models\Editorial;
use Illuminate\Http\Request;

class EditorialController extends Controller
{
    // Mostrar lista de editoriales con sus libros
    public function index()
    {
        $editoriales = Editorial::with('libros')->paginate(10);
        return view('editoriales.index', compact('editoriales'));
    }

    // Formulario para crear una nueva editorial
    public function create()
    {
        return view('editoriales.create');
    }

    // Guardar nueva editorial en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'publisher' => 'required',
            'country' => 'required',
            'founded' => 'required|integer',
            'genere' => 'required',
        ]);

        Editorial::create($request->all());

        return redirect()->route('editoriales.index')->with('success', 'Editorial creada correctamente.');
    }

    // Mostrar detalles de una editorial
    public function show(Editorial $editorial)
    {
        return view('editoriales.show', compact('editorial'));
    }

    // Formulario para editar una editorial
    public function edit(Editorial $editorial)
    {
        return view('editoriales.edit', compact('editorial'));
    }

    // Actualizar datos de una editorial
    public function update(Request $request, Editorial $editorial)
    {
        $request->validate([
            'publisher' => 'required',
            'country' => 'required',
            'founded' => 'required|integer',
            'genere' => 'required',
        ]);

        $editorial->update($request->all());

        return redirect()->route('editoriales.index')->with('success', 'Editorial actualizada correctamente.');
    }

    // Eliminar editorial
    public function destroy(Editorial $editorial)
    {
        $editorial->delete();

        return redirect()->route('editoriales.index')->with('success', 'Editorial eliminada correctamente.');
    }
}
