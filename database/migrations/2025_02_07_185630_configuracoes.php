<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Configuracoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->boolean('status')->nullable();
            $table->string('valores1')->nullable();
            $table->string('conector')->nullable();
            $table->string('valores2')->nullable();
            $table->enum('type',['1','2','3']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Configuracoes');
    }
};
