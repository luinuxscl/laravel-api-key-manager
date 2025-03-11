<?php

namespace Luinuxscl\LaravelApiKeyManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class APIKey extends Model
{
    protected $fillable = [
        'name', 'key', 'service', 'meta'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'api_keys';

    /**
     * Relación polimórfica: la API key puede pertenecer a distintos modelos.
     */
    public function keyable()
    {
        return $this->morphTo();
    }

    /**
     * Obtiene el valor desencriptado de la key.
     *
     * @return string
     */
    public function getDecryptedKey()
    {
        if (config('api_keys.encrypt', true)) {
            return Crypt::decryptString($this->key);
        }

        return $this->key;
    }

    /**
     * Establece el valor de la key, encriptándolo si está configurado así.
     *
     * @param string $value
     * @return void
     */
    public function setKeyAttribute($value)
    {
        if (config('api_keys.encrypt', true)) {
            $this->attributes['key'] = Crypt::encryptString($value);
        } else {
            $this->attributes['key'] = $value;
        }
    }
}
