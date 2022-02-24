<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArmazemInsumoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('armazem_insumo', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('armazem_id')->nullable();
            $table->foreign('armazem_id')->references('id')->on('armazems')->onDelete('cascade');

            $table->unsignedBigInteger('insumo_id')->nullable();
            $table->foreign('insumo_id')->references('id')->on('insumos')->onDelete('cascade');

            $table->double("volume")->nullable();
            $table->double("lastro")->nullable();

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
        Schema::dropIfExists('armazem_insumo');
    }
}
