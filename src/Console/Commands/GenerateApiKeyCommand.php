<?php

namespace Luinuxscl\LaravelApiKeyManager\Console\Commands;

use Illuminate\Console\Command;
use Luinuxscl\LaravelApiKeyManager\Models\APIKey;
use Illuminate\Support\Str;

class GenerateApiKeyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api-key:generate 
                            {name : Nombre descriptivo para la API key}
                            {service : Servicio al que pertenece la API key}
                            {--length=32 : Longitud de la API key a generar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera una nueva API key para un servicio específico';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $service = $this->argument('service');
        $length = $this->option('length');

        // Generar una key aleatoria
        $key = Str::random($length);

        // Crear el registro en la base de datos
        $apiKey = APIKey::create([
            'name' => $name,
            'service' => $service,
            'key' => $key,
            'meta' => [
                'generated_at' => now()->toDateTimeString(),
                'generated_by' => 'console',
            ],
        ]);

        $this->info('API Key generada exitosamente:');
        $this->table(
            ['ID', 'Nombre', 'Servicio', 'Key'],
            [[$apiKey->id, $apiKey->name, $apiKey->service, $key]]
        );

        $this->warn('Guarda esta key en un lugar seguro, no podrás verla nuevamente en texto plano.');

        return Command::SUCCESS;
    }
}
