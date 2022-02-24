<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutoVendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto_venda', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('venda_id')->nullable();
            $table->foreign('venda_id')->references('id')->on('vendas')->onDelete('cascade');

            $table->unsignedBigInteger('produto_id')->nullable();
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');

            $table->string("uniq_code")->nullable();
            $table->double("qtd_sale")->nullable();
            $table->integer("armazem_id")->nullable();
            $table->enum("detail_type", [
                "normal",
                "antecipacao"
            ]);
            $table->double("qtd_delivered")->nullable();
            $table->date("date_retirada")->nullable();

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
        Schema::dropIfExists('produto_venda');
    }
}
