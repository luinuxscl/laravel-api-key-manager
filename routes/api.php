<?php

use Illuminate\Support\Facades\Route;
use Luinuxscl\LaravelApiKeyManager\Http\Controllers\APIKeyController;

Route::group(['middleware' => ['api']], function () {
    Route::apiResource('api-keys', APIKeyController::class);
});
