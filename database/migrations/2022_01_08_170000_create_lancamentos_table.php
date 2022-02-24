<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLancamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lancamentos', function (Blueprint $table) {
            $table->id();

            $table->date("transaction_date");   //data em que a transação ocorreu
            $table->date("date");   //data que será regstrada nos relatólrios (compoetência)

            //usuário que fez o lançamento
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            //pedido atrelado ao lançamento, quando aplicável (para rastrear de qual pedido se trata)
            $table->unsignedBigInteger('pedido_id')->nullable();
            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');

            //pedido atrelado ao lançamento, quando aplicável (para rastrear de qual venda se trata)
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');

            $table->unsignedBigInteger('produto_id')->nullable();
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');

            $table->string("document")->nullable(); //documento comprobatório da transação (NF, protocolo etc)

            $table->unsignedBigInteger('insumo_id')->nullable();
            $table->foreign('insumo_id')->references('id')->on('insumos')->onDelete('cascade');

            $table->unsignedBigInteger('armazem_id')->nullable();
            $table->foreign('armazem_id')->references('id')->on('armazems')->onDelete('cascade');

            $table->enum("type", ["forecast", "real"]);
            $table->enum("category", [
                "Entrada Navio", 
                "Ajuste Estoque",
                "Empréstimo/Devolução",
                "Venda",
                "Transferência"
            ]);
            $table->enum("moviment_type", ["entrada", "saida"]);
            $table->double("qtd");
           

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
        Schema::dropIfExists('lancamentos');
    }
}
