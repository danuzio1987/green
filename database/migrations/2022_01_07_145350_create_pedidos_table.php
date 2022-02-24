<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();

            $table->date("solicitation_date");  //data da solicitação

            $table->unsignedBigInteger('usina_id')->nullable();
            $table->foreign('usina_id')->references('id')->on('usinas')->onDelete('cascade');

            $table->unsignedBigInteger('fornecedor_id')->nullable();
            $table->foreign('fornecedor_id')->references('id')->on('fornecedors')->onDelete('cascade');

            $table->enum("tipo_entrega", ["navio", "transferencia", "outro"]);

            $table->enum("order_status", ["analise", "aprovado", "reprovado", "concluido"]);

            $table->date("delivery_date")->nullable();
            
            //janela de entrega
            $table->date('window_start')->nullable();
            $table->date('window_finish')->nullable();

            $table->string('document')->nullable();

            $table->text("notes")->nullable();

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
        Schema::dropIfExists('pedidos');
    }
}
