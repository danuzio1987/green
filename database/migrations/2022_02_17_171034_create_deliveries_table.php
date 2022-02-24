<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('venda_id')->nullable();
            $table->foreign('venda_id')->references('id')->on('vendas')->onDelete('cascade');

            $table->string("uniq_code")->nullable();
            $table->integer("entrega_produto_id")->nullable();
            $table->integer("entrega_armazem_id")->nullable();

            $table->date("entrega_delivery_date")->nullable();
            $table->double("entrega_qtd_delivered")->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}
