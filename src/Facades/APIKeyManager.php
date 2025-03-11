<?php

namespace Luinuxscl\LaravelApiKeyManager\Facades;

use Illuminate\Support\Facades\Facade;
use Luinuxscl\LaravelApiKeyManager\Models\APIKey;

class APIKeyManager extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'api-key-manager';
    }
}
