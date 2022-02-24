<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalhamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalhamentos', function (Blueprint $table) {
            $table->id();

            $table->morphs("detail");

            //usuário que fez o lançamento
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('insumo_id')->nullable();
            $table->foreign('insumo_id')->references('id')->on('insumos')->onDelete('cascade');

            $table->unsignedBigInteger('armazem_id')->nullable();
            $table->foreign('armazem_id')->references('id')->on('armazems')->onDelete('cascade');

            $table->integer("product_id")->nullable();
            $table->string("uniq_code")->nullable();

            $table->date("date_report");   //data que será regstrada nos relatólrios (compoetência)

            $table->string("document")->nullable(); //documento comprobatório da transação (NF, protocolo etc)
            $table->enum("type", ["forecast", "real", "canceled"]);
            $table->enum("category", [
                "Entrada Navio", 
                "Ajuste Estoque",
                "Empréstimo/Devolução",
                "Venda",
                "Transferência"
            ]);
            $table->enum("moviment_type", ["entrada", "saida"]);
            $table->double("qtd");

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
        Schema::dropIfExists('detalhamentos');
    }
}
