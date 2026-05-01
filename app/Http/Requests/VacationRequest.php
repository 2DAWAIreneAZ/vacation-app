<?php

namespace App\Http\Requests\Vacation;

use Illuminate\Foundation\Http\FormRequest;

class VacationRequest extends FormRequest {
    public function authorize(): bool {
        return auth()->check() && auth()->user()->canManageVacations();
    }

    public function rules(): array {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price'       => ['required', 'numeric', 'min:0'],
            'id_type'     => ['required', 'exists:types,id'],
            'country'     => ['required', 'string', 'max:100'],
            // Imágenes: opcional en edición, array de archivos de imagen
            'images'      => ['nullable', 'array'],
            'images.*'    => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    public function messages(): array {
        return [
            'title.required'       => 'El título es obligatorio.',
            'description.required' => 'La descripción es obligatoria.',
            'price.required'       => 'El precio es obligatorio.',
            'price.numeric'        => 'El precio debe ser un número.',
            'price.min'            => 'El precio no puede ser negativo.',
            'id_type.required'     => 'El tipo de paquete es obligatorio.',
            'id_type.exists'       => 'El tipo seleccionado no existe.',
            'country.required'     => 'El país es obligatorio.',
            'images.*.image'       => 'Cada archivo debe ser una imagen.',
            'images.*.mimes'       => 'Las imágenes deben ser jpeg, png, jpg o webp.',
            'images.*.max'         => 'Cada imagen no puede superar los 2 MB.',
        ];
    }
}