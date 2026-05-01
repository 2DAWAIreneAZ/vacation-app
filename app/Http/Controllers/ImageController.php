<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    function imagen($id) {
        $vacacion = Vacacion::find($id);
        
        if ($vacation->image && file_exists(public_path('storage/' . $vacation->image))) {
            return response()->file(public_path('storage/' . $vacation->image));
        }

        return response()->file(public_path('images/noimage.jpg'));
    }

		public function destroy(Image $image)
    {
        try {
						$vacationId = $image->id_vacation;

						if ($image->route && Storage::disk('public')->exists($image->route)) {
								Storage::disk('public')->delete($image->route);
						}

						$image->delete();

						return redirect()
								->route('vacations.show', $vacationId)
								->with('success', 'Imagen eliminada correctamente.');

				} catch (\Throwable $e) {
						return back()->with('error', $e->getMessage());
				}
    }
}
