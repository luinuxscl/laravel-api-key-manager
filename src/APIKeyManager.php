<?php

namespace Luinuxscl\LaravelApiKeyManager;

use Illuminate\Support\Str;
use Luinuxscl\LaravelApiKeyManager\Models\APIKey;

class APIKeyManager
{
    /**
     * Genera una nueva API key para un servicio específico.
     *
     * @param string $name Nombre descriptivo para la API key
     * @param string $service Servicio al que pertenece la API key
     * @param int $length Longitud de la API key a generar
     * @param array $meta Metadatos adicionales para la API key
     * @param mixed $keyable Modelo al que se asociará la API key (relación polimórfica)
     * @return \Luinuxscl\LaravelApiKeyManager\Models\APIKey
     */
    public function generate(string $name, string $service, int $length = 32, array $meta = [], $keyable = null)
    {
        // Generar una key aleatoria
        $key = Str::random($length);

        // Preparar los metadatos
        $metadata = array_merge([
            'generated_at' => now()->toDateTimeString(),
        ], $meta);

        // Crear el registro en la base de datos
        $apiKey = new APIKey([
            'name' => $name,
            'service' => $service,
            'key' => $key,
            'meta' => $metadata,
        ]);

        // Asociar con el modelo keyable si se proporciona
        if ($keyable) {
            $apiKey->keyable()->associate($keyable);
        }

        $apiKey->save();

        return $apiKey;
    }

    /**
     * Obtiene una API key por su ID.
     *
     * @param int $id
     * @return \Luinuxscl\LaravelApiKeyManager\Models\APIKey|null
     */
    public function find(int $id)
    {
        return APIKey::find($id);
    }

    /**
     * Obtiene todas las API keys para un servicio específico.
     *
     * @param string|null $service
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByService(?string $service = null)
    {
        $query = APIKey::query();
        
        if ($service) {
            $query->where('service', $service);
        }
        
        return $query->get();
    }

    /**
     * Obtiene todas las API keys asociadas a un modelo específico.
     *
     * @param mixed $keyable
     * @param string|null $service
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getForKeyable($keyable, ?string $service = null)
    {
        $query = $keyable->apiKeys();
        
        if ($service) {
            $query->where('service', $service);
        }
        
        return $query->get();
    }

    /**
     * Elimina una API key por su ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id)
    {
        $apiKey = $this->find($id);
        
        if (!$apiKey) {
            return false;
        }
        
        return $apiKey->delete();
    }
}
