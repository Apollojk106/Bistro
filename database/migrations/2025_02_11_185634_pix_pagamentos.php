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
        Schema::create('Pix_pagamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('telefone');
            $table->string('email');
            $table->foreignId('id_pedido')->constrained('Pedidos');
            $table->decimal('valor_total', 8, 2);
            $table->string('pix_key'); // Chave PIX do usuário
            $table->string('pix_code'); // Código gerado para o pagamento PIX
            $table->enum('status', ['Pendente', 'Pago', 'Falhou'])->default('Pendente'); // Status do pagamento
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Pix_pagamentos');
    }
};
