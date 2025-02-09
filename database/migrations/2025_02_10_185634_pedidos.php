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
        Schema::create('Pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email');
            $table->string('telefone');
            $table->string('rua')->nullable();
            $table->string('bairro')->nullable();
            $table->string('numero_residencia')->nullable();
            $table->string('complemento')->nullable();
            $table->enum('categoria_pedido', ['Local', 'Entrega']);
            $table->enum('status_pedido', ['Pago', 'Pendente']);
            $table->enum('opcao_entrega', ['Agora', 'Viagem', 'Agendamento']);
            $table->timestamp('horario')->nullable();
            $table->foreignId('id_forma_pagamento')->constrained('Formas_de_pagamento');
            $table->text('descricao')->nullable();
            $table->decimal('frete', 8, 2);
            $table->decimal('valor_total', 8, 2);
            $table->decimal('valor_taxa', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Pedidos');
    }
};
