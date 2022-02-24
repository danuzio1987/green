<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferencias', function (Blueprint $table) {
            $table->id();

            $table->date("transfer_date");  //data da carga
            $table->date("descarga_date");  //data da descarga
            $table->enum('delivery_status', ['andamento', 'concluida']);
            $table->integer('origem_id');
            $table->double("qtd_origem")->nullable();
            $table->integer('destino_id');
            $table->double("qtd_destino")->nullable();
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
        Schema::dropIfExists('transferencias');
    }
}
