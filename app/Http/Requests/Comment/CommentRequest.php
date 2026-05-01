<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest {
    public function authorize(): bool {
        return auth()->check();
    }

    public function rules(): array {
        return [
            'text' => ['required', 'string', 'max:1000'],
        ];
    }

    public function messages(): array {
        return [
            'text.required' => 'El comentario no puede estar vacío.',
            'text.max'      => 'El comentario no puede superar los 1000 caracteres.',
        ];
    }
}