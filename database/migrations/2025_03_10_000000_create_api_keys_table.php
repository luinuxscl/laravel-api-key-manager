<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('api_keys', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key');
            $table->string('service');
            $table->json('meta')->nullable();
            // Campos para la relación polimórfica
            $table->unsignedBigInteger('keyable_id')->nullable();
            $table->string('keyable_type')->nullable();
            $table->timestamps();

            // Índices para mejorar las consultas polimórficas
            $table->index(['keyable_id', 'keyable_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('api_keys');
    }
};
