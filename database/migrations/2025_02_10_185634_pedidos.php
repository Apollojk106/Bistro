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
            $table->enum('status', ['Pendente','EmAndamento','Concluido'])->default('Pendente')->nullable();
            $table->timestamp('horario')->nullable();
            $table->text('descricao')->nullable();
            $table->decimal('frete', 8, 2);
            $table->decimal('valor_total', 8, 2);
            $table->decimal('valor_pago', 8, 2)->default(0.00);
            
            // Add the 'id_forma_pagamento' column before defining the foreign key
            $table->unsignedBigInteger('id_forma_pagamento')->nullable();  // Add this line to define the column

            // Define the foreign key constraint
            $table->foreign('id_forma_pagamento')
                ->references('id')
                ->on('Formas_de_pagamento')
                ->onDelete('cascade');

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
