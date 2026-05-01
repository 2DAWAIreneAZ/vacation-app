<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    function imagen($id) {
        $vacacion = Vacacion::find($id);
        
        if ($vacation->image && file_exists(public_path('storage/' . $vacation->image))) {
            return response()->file(public_path('storage/' . $vacation->image));
        }

        return response()->file(public_path('images/noimage.jpg'));
    }
}
