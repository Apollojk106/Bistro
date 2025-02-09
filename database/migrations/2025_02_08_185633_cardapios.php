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
        Schema::create('Cardapios', function (Blueprint $table) {
            $table->id();
            $table->string('imagem');
            $table->string('nome');
            $table->text('descricao');
            $table->decimal('valor', 8, 2);
            $table->decimal('desconto', 8, 2)->default(0);
            $table->string('disponibilidade'); // Ex: "Todo dia", "Segunda", etc.
            $table->text('ingredientes');
            $table->foreignId('id_categoria')->constrained('Categorias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Cardapios');
    }
};
