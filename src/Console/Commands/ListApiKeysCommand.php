<?php

namespace Luinuxscl\LaravelApiKeyManager\Console\Commands;

use Illuminate\Console\Command;
use Luinuxscl\LaravelApiKeyManager\Models\APIKey;

class ListApiKeysCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api-key:list
                            {--service= : Filtrar por servicio específico}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lista todas las API keys registradas';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $service = $this->option('service');
        
        $query = APIKey::query();
        
        if ($service) {
            $query->where('service', $service);
        }
        
        $apiKeys = $query->get();
        
        if ($apiKeys->isEmpty()) {
            $this->info('No hay API keys registradas' . ($service ? ' para el servicio ' . $service : '') . '.');
            return Command::SUCCESS;
        }
        
        $this->info('API Keys registradas:');
        $this->table(
            ['ID', 'Nombre', 'Servicio', 'Creada', 'Asociada a'],
            $apiKeys->map(function ($key) {
                return [
                    $key->id,
                    $key->name,
                    $key->service,
                    $key->created_at->format('Y-m-d H:i'),
                    $key->keyable_type && $key->keyable_id ? 
                        $key->keyable_type . ' (ID: ' . $key->keyable_id . ')' : 
                        'No asociada'
                ];
            })
        );
        
        return Command::SUCCESS;
    }
}
