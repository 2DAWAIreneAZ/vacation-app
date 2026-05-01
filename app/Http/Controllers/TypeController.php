<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index()
    {
        $types = Type::withCount('vacations')->orderBy('name')->get();
        return view('types.index', ['types' => $types]);
    }

    public function create()
    {
        return view('types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:types,name',
        ]);

        try {
            Type::create(['name' => $request->name]);

            return redirect()->route('types.index')
                ->with('success', 'Tipo creado correctamente.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error al crear el tipo: ' . $e->getMessage());
        }
    }

    public function edit(Type $type)
    {
        return view('types.edit', ['type' => $type]);
    }

    public function update(Request $request, Type $type)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:types,name,' . $type->id,
        ]);

        try {
            $type->update(['name' => $request->name]);

            return redirect()->route('types.index')
                ->with('success', 'Tipo actualizado correctamente.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error al actualizar el tipo: ' . $e->getMessage());
        }
    }

    public function destroy(Type $type)
    {
        try {
            // Evitar borrar un tipo que tiene paquetes asociados
            if ($type->vacations()->count() > 0) {
                return back()->with('error', 'No puedes eliminar un tipo que tiene paquetes asociados.');
            }

            $type->delete();

            return redirect()->route('types.index')
                ->with('success', 'Tipo eliminado correctamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el tipo: ' . $e->getMessage());
        }
    }
}