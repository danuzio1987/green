<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();

            $table->date("sale_date");  //data da solicitação
            $table->enum("mode", [
                "normal",
                "antecipacao",
                "propriedade",
                "planejamento"
            ]); //venda normal, antecipação ou mudança de propriedade

            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');

            /*
            $table->unsignedBigInteger('produto_id')->nullable();
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
            */
            //$table->integer("armazem_sale")->nullable(); //repetição de informação para fins de relatório
            $table->date("retirada")->nullable(); //repetição de informação para fins de relatório

            //$table->double("qtd_sale")->nullable();
            $table->text("notes")->nullable();

            $table->enum("sale_status", [
                "open", 
                "close"
            ])->nullable();
            
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
        Schema::dropIfExists('vendas');
    }
}
