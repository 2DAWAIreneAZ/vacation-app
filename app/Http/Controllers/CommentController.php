<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\CommentRequest;
use App\Models\Comment;
use App\Models\Vacation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CommentController extends Controller
{
    // Crear comentario

    public function store(CommentRequest $request, Vacation $vacation): RedirectResponse
    {
        try {
            $user = auth()->user();

						
						if (!$vacation || !$vacation->id) {
								abort(404, 'Vacación no encontrada');
						}

            // Solo usuarios que hayan reservado el paquete pueden comentar
            if (!$user->hasReserved($vacation->id)) {
                return back()->with('error', 'Solo puedes comentar paquetes que hayas reservado.');
            }

            Comment::create([
                'id_user'     => $user->id,
                'id_vacation' => $vacation->id,
                'text'        => $request->text,
            ]);

            return redirect()->route('vacations.show', $vacation)
                ->with('success', 'Comentario publicado correctamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al publicar el comentario: ' . $e->getMessage());
        }
    }

    // Formulario editar comentario 

    public function edit(Comment $comment): View
    {
        // Solo el autor puede editar su comentario
        if ($comment->id_user !== auth()->id()) {
            abort(403, 'No puedes editar un comentario que no es tuyo.');
        }

        return view('comments.edit', ['comment' => $comment]);
    }

    // Actualizar comentario

    public function update(CommentRequest $request, Comment $comment): RedirectResponse
    {
        try {
            // Solo el autor puede editar su comentario
            if ($comment->id_user !== auth()->id()) {
                abort(403, 'No puedes editar un comentario que no es tuyo.');
            }

            $comment->update(['text' => $request->text]);

            return redirect()->route('vacations.show', $comment->id_vacation)
                ->with('success', 'Comentario actualizado correctamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el comentario: ' . $e->getMessage());
        }
    }

    // Eliminar comentario

    public function destroy(Comment $comment): RedirectResponse
    {
        try {
            $user = auth()->user();

            // El autor o un admin pueden eliminar el comentario
            if ($comment->id_user !== $user->id && !$user->isAdmin()) {
                abort(403, 'No tienes permiso para eliminar este comentario.');
            }

            $vacationId = $comment->id_vacation;
            $comment->delete();

            return redirect()->route('vacations.show', $vacationId)
                ->with('success', 'Comentario eliminado correctamente.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al eliminar el comentario: ' . $e->getMessage());
        }
    }
}