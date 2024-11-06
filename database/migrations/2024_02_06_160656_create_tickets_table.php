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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id')-> unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->BigInteger('sucursal_id')->unsigned()->nullable();
            $table->foreign('sucursal_id')->references('id')->on('sucursals');
            $table->BigInteger('almacen_id')->unsigned()->nullable();
            $table->foreign('almacen_id')->references('id')->on('almacens');
            $table->BigInteger('proveedor_id')->unsigned()->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
            $table->datetime('fecha');
            $table->integer('numero');
            $table->decimal('total',7,2);
            $table->string('compra',1)->default(0); //1. Añadido a compra - 0. Sin añadir a compra
            $table->string('estado',1)->default(1);
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
        Schema::dropIfExists('tickets');
    }
};
