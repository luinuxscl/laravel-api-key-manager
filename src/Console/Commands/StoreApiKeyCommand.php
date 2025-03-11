<?php

namespace Luinuxscl\LaravelApiKeyManager\Console\Commands;

use Illuminate\Console\Command;
use Luinuxscl\LaravelApiKeyManager\Models\APIKey;

class StoreApiKeyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api-key:store 
                            {name : Nombre descriptivo para la API key}
                            {service : Servicio al que pertenece la API key}
                            {key : La API key existente que desea almacenar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Almacena una API key existente para un servicio específico';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $service = $this->argument('service');
        $key = $this->argument('key');

        // Crear el registro en la base de datos
        $apiKey = APIKey::create([
            'name' => $name,
            'service' => $service,
            'key' => $key,
            'meta' => [
                'stored_at' => now()->toDateTimeString(),
                'stored_by' => 'console',
            ],
        ]);

        $this->info('API Key almacenada exitosamente:');
        $this->table(
            ['ID', 'Nombre', 'Servicio'],
            [[$apiKey->id, $apiKey->name, $apiKey->service]]
        );

        $this->warn('La API key ha sido almacenada de forma segura.');

        return Command::SUCCESS;
    }
}
