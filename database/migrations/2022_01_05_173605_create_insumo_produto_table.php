<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsumoProdutoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo_produto', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('insumo_id')->nullable();
            $table->foreign('insumo_id')->references('id')->on('insumos')->onDelete('cascade');

            $table->unsignedBigInteger('produto_id')->nullable();
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');

            $table->double("percent")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo_produto');
    }
}
