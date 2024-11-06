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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('sucursal_id')->unsigned()->nullable();
            $table->foreign('sucursal_id')->references('id')->on('sucursals');
            $table->BigInteger('almacen_id')->unsigned();
            $table->foreign('almacen_id')->references('id')->on('almacens');
            $table->BigInteger('tipo_id')->unsigned();
            $table->foreign('tipo_id')->references('id')->on('tipos');
            $table->BigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->BigInteger('proveedor_id')->unsigned()->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
            $table->BigInteger('movimiento_id')->unsigned()->nullable();
            $table->foreign('movimiento_id')->references('id')->on('movimientos');
            $table->string('tipo_doc');
            $table->string('nume_doc')->nullable();
            $table->datetime('fecha');
            $table->string('estadoMovimiento',1)->default(1);
            $table->string('estado', 1)->default(1);
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
        Schema::dropIfExists('movimientos');
    }
};
