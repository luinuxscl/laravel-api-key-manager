<?php

namespace Luinuxscl\LaravelApiKeyManager\Traits;

use Luinuxscl\LaravelApiKeyManager\Models\APIKey;

trait HasApiKeys
{
    /**
     * Obtiene todas las API keys asociadas a este modelo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function apiKeys()
    {
        return $this->morphMany(APIKey::class, 'keyable');
    }

    /**
     * Obtiene las API keys asociadas a este modelo para un servicio específico.
     *
     * @param string $service
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getApiKeysForService(string $service)
    {
        return $this->apiKeys()->where('service', $service)->get();
    }

    /**
     * Genera una nueva API key asociada a este modelo.
     *
     * @param string $name
     * @param string $service
     * @param array $meta
     * @param int $length
     * @return \Luinuxscl\LaravelApiKeyManager\Models\APIKey
     */
    public function generateApiKey(string $name, string $service, array $meta = [], int $length = 32)
    {
        return app('api-key-manager')->generate($name, $service, $length, $meta, $this);
    }
}
