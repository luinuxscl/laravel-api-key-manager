<?php

namespace Luinuxscl\LaravelApiKeyManager\Providers;

use Illuminate\Support\ServiceProvider;
use Luinuxscl\LaravelApiKeyManager\Console\Commands\GenerateApiKeyCommand;
use Luinuxscl\LaravelApiKeyManager\Console\Commands\ListApiKeysCommand;

class APIKeyManagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publicar el archivo de configuración
        $this->publishes([
            __DIR__.'/../../config/api_keys.php' => config_path('api_keys.php'),
        ], 'config');

        // Publicar migraciones
        if (! class_exists('CreateApiKeysTable')) {
            $this->publishes([
                __DIR__.'/../../database/migrations/2025_03_10_000000_create_api_keys_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_api_keys_table.php'),
            ], 'migrations');
        }

        // Registrar comandos Artisan
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateApiKeyCommand::class,
                ListApiKeysCommand::class,
                StoreApiKeyCommand::class,
            ]);
        }
    }

    public function register()
    {
        // Fusiona la configuración del package con la del proyecto
        $this->mergeConfigFrom(
            __DIR__.'/../../config/api_keys.php', 'api_keys'
        );

        // Registrar el singleton para el facade
        $this->app->singleton('api-key-manager', function ($app) {
            return new \Luinuxscl\LaravelApiKeyManager\APIKeyManager();
        });
    }
}
