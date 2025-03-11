# Laravel API Key Manager

Un package para Laravel que facilita la gestión de API Keys de servicios externos. Permite almacenar, encriptar y asociar API keys a diferentes modelos de tu aplicación mediante relaciones polimórficas.

## Características

- Almacenamiento seguro de API keys con encriptación opcional
- Relaciones polimórficas para asociar API keys a cualquier modelo de tu aplicación
- Comandos Artisan para la gestión de API keys
- Facade para un acceso simplificado a las funcionalidades del package
- Configuración personalizable

## Instalación

Puedes instalar el package a través de Composer:

```bash
composer require luinuxscl/laravel-api-key-manager
```

## Publicación de archivos

Después de instalar el package, publica los archivos de configuración y migraciones:

```bash
php artisan vendor:publish --provider="Luinuxscl\LaravelApiKeyManager\Providers\APIKeyManagerServiceProvider"
```

O publica solo lo que necesites:

```bash
# Solo configuración
php artisan vendor:publish --provider="Luinuxscl\LaravelApiKeyManager\Providers\APIKeyManagerServiceProvider" --tag="config"

# Solo migraciones
php artisan vendor:publish --provider="Luinuxscl\LaravelApiKeyManager\Providers\APIKeyManagerServiceProvider" --tag="migrations"
```

Finalmente, ejecuta las migraciones:

```bash
php artisan migrate
```

## Configuración

El archivo de configuración `config/api_keys.php` te permite personalizar el comportamiento del package:

```php
return [
    // Define si las API keys deben ser encriptadas al guardarse en la base de datos
    'encrypt' => true,
    
    // Servicio por defecto
    'default_service' => null,
];
```

## Uso básico

### Usando la Facade

```php
use Luinuxscl\LaravelApiKeyManager\Facades\APIKeyManager;

// Generar una nueva API key
$apiKey = APIKeyManager::generate('Mi API Key', 'google-maps', 32, ['environment' => 'production']);

// Obtener el valor de la key (desencriptado si corresponde)
$keyValue = $apiKey->getDecryptedKey();

// Obtener todas las API keys para un servicio específico
$googleKeys = APIKeyManager::getByService('google-maps');
```

### Asociar API keys a modelos

Para asociar API keys a tus modelos, utiliza el trait `HasApiKeys`:

```php
use Illuminate\Database\Eloquent\Model;
use Luinuxscl\LaravelApiKeyManager\Traits\HasApiKeys;

class User extends Model
{
    use HasApiKeys;
    
    // ...
}
```

Ahora puedes generar y gestionar API keys asociadas a tus modelos:

```php
$user = User::find(1);

// Generar una API key asociada al usuario
$apiKey = $user->generateApiKey('API Key de Juan', 'stripe', ['role' => 'admin']);

// Obtener todas las API keys del usuario
$allKeys = $user->apiKeys;

// Obtener las API keys del usuario para un servicio específico
$stripeKeys = $user->getApiKeysForService('stripe');
```

### Comandos Artisan

El package incluye comandos Artisan para gestionar API keys desde la consola:

```bash
# Generar una nueva API key
php artisan api-key:generate "API Key de Producción" google-maps

# Listar todas las API keys
php artisan api-key:list

# Listar API keys para un servicio específico
php artisan api-key:list --service=google-maps
```

## Seguridad

Las API keys se encriptan por defecto utilizando el mecanismo de encriptación de Laravel. Puedes desactivar esta característica en el archivo de configuración.

## Licencia

Este package es software de código abierto licenciado bajo la [licencia MIT](LICENSE.md).
