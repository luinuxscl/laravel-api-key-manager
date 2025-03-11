<?php

namespace Luinuxscl\LaravelApiKeyManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAPIKeyRequest extends FormRequest
{
    public function authorize()
    {
        // Personaliza la autorización si es necesario.
        return true;
    }

    public function rules()
    {
        return [
            'name'    => 'required|string|max:255',
            'key'     => 'required|string|max:255',
            'service' => 'required|string|max:255',
            'meta'    => 'nullable|array',
        ];
    }
}
