<?php

namespace Luinuxscl\LaravelApiKeyManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAPIKeyRequest extends FormRequest
{
    public function authorize()
    {
        // Personaliza la autorización si es necesario.
        return true;
    }

    public function rules()
    {
        return [
            'name'    => 'sometimes|required|string|max:255',
            'key'     => 'sometimes|required|string|max:255',
            'service' => 'sometimes|required|string|max:255',
            'meta'    => 'nullable|array',
        ];
    }
}
