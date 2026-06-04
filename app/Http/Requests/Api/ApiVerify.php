<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ApiVerify extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3'],
            'cover' => ['nullable', 'file', 'mimes:png', 'mimetypes:image/png', 'max:2048'],
            'seasonQty' => ['required'],
            'episodePerSeason' => ['required']
        ];
    }
}