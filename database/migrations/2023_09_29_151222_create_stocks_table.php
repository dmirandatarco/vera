<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('almacen_id')->unsigned()->nullable();
            $table->foreign('almacen_id')->references('id')->on('almacens');
            $table->BigInteger('producto_id')->unsigned()->nullable();
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->integer('cantidad')->default(0);
            $table->string('ubicacion',100)->nullable();
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
        Schema::dropIfExists('stocks');
    }
};
