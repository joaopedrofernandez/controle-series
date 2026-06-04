<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SeriesFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'min:3'],
            'cover' => ['nullable', 'file', 'mimes:png', 'mimetypes:image/png', 'max:2048']
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => "O campo :attribute é obrigatório",
            'nome.min' => "E nescesario que tenha pelo menos :min caracteres",
            'cover.mimes' => "O arquivo deve ser o png",
            'cover.max' => "O arquivo deve ser de tamanho de no maximo :max Kb"
        ];
    }
}