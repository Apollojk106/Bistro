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
        Schema::create('Itens_pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pedido')->constrained('Pedidos');
            $table->foreignId('id_cardapio')->constrained('Cardapios');
            $table->integer('quantidade');
            $table->decimal('valor_unitario', 8, 2);
            $table->decimal('subtotal', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Itens_pedidos');
    }
};
