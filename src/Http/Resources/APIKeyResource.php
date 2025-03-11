<?php

namespace Luinuxscl\LaravelApiKeyManager\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class APIKeyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'key'        => $this->key, // O puedes enmascarar el valor si es información sensible
            'service'    => $this->service,
            'meta'       => $this->meta,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
