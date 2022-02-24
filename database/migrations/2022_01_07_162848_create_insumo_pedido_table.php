<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsumoPedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo_pedido', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('insumo_id')->nullable();
            $table->foreign('insumo_id')->references('id')->on('insumos')->onDelete('cascade');

            $table->unsignedBigInteger('pedido_id')->nullable();
            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');
            
            $table->integer("armazem_id");
            $table->enum("type", ["pedido", "entrega"]);
            $table->double("qtd_forecast"); //quantidade original do pedido
            $table->double("qtd_real"); //quantidade entregue/real
            $table->date('data_descarga_item_pedido')->nullable();

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
        Schema::dropIfExists('insumo_pedido');
    }
}
