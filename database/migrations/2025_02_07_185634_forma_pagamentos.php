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
        Schema::create('Formas_de_pagamento', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->boolean('status')->default(true);
            $table->decimal('taxa', 5, 2);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Formas_de_pagamento');
    }
};
