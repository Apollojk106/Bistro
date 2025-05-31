<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnotacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Anotacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Chave estrangeira para users
            $table->text('conteudo');
            $table->timestamps();

            // Define a chave estrangeira
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anotacoes');
    }
}
