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
        Schema::create('Categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // Campo para o nome da categoria
            $table->enum('nivel', ['Primaria', 'Secundaria', 'Terciaria'])->default('Primaria'); 
            // Campo para o nível com valor default
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Categorias');
    }
};
