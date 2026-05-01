<?php

namespace App\Http\Controllers;

use App\Models\Vacation;
use App\Models\Type;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VacationController extends Controller
{
    // ──────────────────────────────────────────────
    // Página pública (sin login) – welcome
    // ──────────────────────────────────────────────
    public function welcome(Request $request)
    {
        $query = Vacation::with(['type', 'images']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('type')) {
            $query->where('id_type', $request->type);
        }

        if ($request->filled('country')) {
            $query->where('country', 'like', '%' . $request->country . '%');
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $vacations = $query->paginate(12);
        $types     = Type::orderBy('name')->get();

        return view('welcome', ['types' => $types, 'vacations' => $vacations]);
    }

    // ──────────────────────────────────────────────
    // Listado autenticado con filtros
    // ──────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Vacation::with(['type', 'images']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('type')) {
            $query->where('id_type', $request->type);
        }

        if ($request->filled('country')) {
            $query->where('country', 'like', '%' . $request->country . '%');
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $vacations = $query->paginate(12);
        $types     = Type::orderBy('name')->get();

        return view('vacations.index', ['types' => $types, 'vacations' => $vacations]);
    }

    // ──────────────────────────────────────────────
    // Detalle de un paquete
    // ──────────────────────────────────────────────
    public function show(Vacation $vacation)
    {
        $vacation->load([
            'type',
            'images',
            'reserves',
            'comments.user',
        ]);

        return view('vacations.show', ['vacation' => $vacation]);
    }

    // ──────────────────────────────────────────────
    // Formulario de creación
    // ──────────────────────────────────────────────
    public function create()
    {
        $types = Type::orderBy('name')->get();
        return view('vacations.create', ['types' => $types]);
    }

    // ──────────────────────────────────────────────
    // Guardar nuevo paquete
    // ──────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'country'     => 'required|string|max:100',
            'id_type'     => 'required|exists:types,id',
            'images'      => 'nullable|array|max:10',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            $vacation = Vacation::create([
                'id_user'     => Auth::id(),
                'id_type'     => $request->id_type,
                'title'       => $request->title,
                'description' => $request->description,
                'price'       => $request->price,
                'country'     => $request->country,
            ]);

            // Subir imágenes
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('vacations', 'public');
                    Image::create([
                        'id_vacation' => $vacation->id,
                        'route'       => $path,
                    ]);
                }
            }

            return redirect()->route('vacations.show', $vacation)
                ->with('success', 'Paquete vacacional creado correctamente.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error al crear el paquete: ' . $e->getMessage());
        }
    }

    // ──────────────────────────────────────────────
    // Formulario de edición
    // ──────────────────────────────────────────────
    public function edit(Vacation $vacation)
    {
        // El advanced solo puede editar los suyos
        if (Auth::user()->rol === 'advanced' && $vacation->id_user !== Auth::id()) {
            abort(403, 'No tienes permiso para editar este paquete.');
        }

        $types = Type::orderBy('name')->get();
        $vacation->load('images');

        return view('vacations.edit', ['vacation' => $vacation, 'types' => $types]);
    }

    // ──────────────────────────────────────────────
    // Actualizar paquete
    // ──────────────────────────────────────────────
    public function update(Request $request, Vacation $vacation)
    {
        if (Auth::user()->rol === 'advanced' && $vacation->id_user !== Auth::id()) {
            abort(403, 'No tienes permiso para editar este paquete.');
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'country'     => 'required|string|max:100',
            'id_type'     => 'required|exists:types,id',
            'images'      => 'nullable|array',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Comprobar límite de 10 imágenes
        $currentCount = $vacation->images()->count();
        $newCount     = $request->hasFile('images') ? count($request->file('images')) : 0;

        if ($currentCount + $newCount > 10) {
            return back()->withInput()
                ->with('error', "No puedes superar 10 imágenes. Tienes {$currentCount} y estás intentando añadir {$newCount}.");
        }

        try {
            $vacation->update([
                'id_type'     => $request->id_type,
                'title'       => $request->title,
                'description' => $request->description,
                'price'       => $request->price,
                'country'     => $request->country,
            ]);

            // Subir nuevas imágenes
            if ($request->hasFile('images')) {
								foreach ($request->file('images') as $file) {
										$path = $file->store('vacations', 'public');

										Image::create([
												'id_vacation' => $vacation->id,
												'route'       => $path,
										]);
								}
						}

            return redirect()->route('vacations.show', $vacation)
                ->with('success', 'Paquete actualizado correctamente.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error al actualizar el paquete: ' . $e->getMessage());
        }
    }

    // ──────────────────────────────────────────────
    // Eliminar paquete
    // ──────────────────────────────────────────────
    public function destroy(Vacation $vacation)
    {
        if (Auth::user()->rol === 'advanced' && $vacation->id_user !== Auth::id()) {
            abort(403, 'No tienes permiso para eliminar este paquete.');
        }

        try {
            // Eliminar imágenes del storage antes de borrar el registro
            foreach ($vacation->images as $image) {
                Storage::disk('public')->delete($image->route);
            }

            $vacation->delete(); // cascada elimina images, reserves y comments

            return redirect()->route('vacations.index')
                ->with('success', 'Paquete eliminado correctamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el paquete: ' . $e->getMessage());
        }
    }
}