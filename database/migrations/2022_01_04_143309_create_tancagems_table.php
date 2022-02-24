<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTancagemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tancagems', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('insumo_id')->nullable();
            $table->foreign('insumo_id')->references('id')->on('insumos')->onDelete('cascade');

            $table->unsignedBigInteger('armazem_id')->nullable();
            $table->foreign('armazem_id')->references('id')->on('armazems')->onDelete('cascade');

            $table->double("volume")->nullable();

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
        Schema::dropIfExists('tancagems');
    }
}
