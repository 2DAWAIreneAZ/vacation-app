<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use App\Models\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReserveController extends Controller
{
    // Listado de reservas del usuario autenticado
    public function index()
    {
        $reserves = Reserve::with(['vacation.images', 'vacation.type'])
            ->where('id_user', Auth::id())
            ->latest()
            ->paginate(10);

        return view('reserves.index', ['reserves' => $reserves]);
    }

    // Crear una reserva
    public function store(Request $request)
    {
        $request->validate([
            'id_vacation' => 'required|exists:vacations,id',
        ]);

        try {
            // Comprobar si el usuario ya tiene este paquete reservado
            $existe = Reserve::where('id_user', Auth::id())
                ->where('id_vacation', $request->id_vacation)
                ->exists();

            if ($existe) {
                return back()->with('error', 'Ya tienes este paquete reservado.');
            }

            Reserve::create([
                'id_user'     => Auth::id(),
                'id_vacation' => $request->id_vacation,
            ]);

            return back()->with('success', '¡Reserva realizada correctamente! Ya puedes comentar este paquete.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al realizar la reserva: ' . $e->getMessage());
        }
    }

    // Cancelar una reserva
    public function destroy(Reserve $reserve)
    {
        // Solo el propietario puede cancelar su reserva
        if ($reserve->id_user !== Auth::id()) {
            abort(403, 'No puedes cancelar una reserva que no es tuya.');
        }

        try {
            $reserve->delete();

            return back()->with('success', 'Reserva cancelada correctamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al cancelar la reserva: ' . $e->getMessage());
        }
    }
}