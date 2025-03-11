<?php

namespace Luinuxscl\LaravelApiKeyManager\Http\Controllers;

use Luinuxscl\LaravelApiKeyManager\Models\APIKey;
use Illuminate\Http\Request;
use Luinuxscl\LaravelApiKeyManager\Http\Requests\StoreAPIKeyRequest;
use Luinuxscl\LaravelApiKeyManager\Http\Requests\UpdateAPIKeyRequest;
use Luinuxscl\LaravelApiKeyManager\Http\Resources\APIKeyResource;

class APIKeyController extends Controller
{
    /**
     * Muestra una lista paginada de API Keys.
     */
    public function index()
    {
        $keys = APIKey::paginate(15);
        return APIKeyResource::collection($keys);
    }

    /**
     * Almacena una nueva API Key.
     */
    public function store(StoreAPIKeyRequest $request)
    {
        $data = $request->validated();

        $apiKey = APIKey::create($data);

        return new APIKeyResource($apiKey);
    }

    /**
     * Muestra los detalles de una API Key en específico.
     */
    public function show(APIKey $apiKey)
    {
        return new APIKeyResource($apiKey);
    }

    /**
     * Actualiza la API Key.
     */
    public function update(UpdateAPIKeyRequest $request, APIKey $apiKey)
    {
        $data = $request->validated();

        $apiKey->update($data);

        return new APIKeyResource($apiKey);
    }

    /**
     * Elimina la API Key.
     */
    public function destroy(APIKey $apiKey)
    {
        $apiKey->delete();
        return response()->json(['message' => 'API Key eliminada correctamente.'], 200);
    }
}
