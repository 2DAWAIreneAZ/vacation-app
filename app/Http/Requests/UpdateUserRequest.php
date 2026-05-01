<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest {
    public function authorize(): bool {
        // Solo admin puede actualizar cualquier usuario
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array {
        $userId = $this->route('user')?->id ?? $this->route('id');

        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'rol'      => ['required', 'in:admin,advanced,normal'],
        ];
    }

    public function messages(): array {
        return [
            'name.required'      => 'El nombre es obligatorio.',
            'email.required'     => 'El email es obligatorio.',
            'email.email'        => 'El email no tiene un formato válido.',
            'email.unique'       => 'Este email ya está en uso.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'rol.required'       => 'El rol es obligatorio.',
            'rol.in'             => 'El rol debe ser admin, advanced o normal.',
        ];
    }
}