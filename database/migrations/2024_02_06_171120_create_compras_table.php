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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('sucursal_id')->unsigned()->nullable();
            $table->foreign('sucursal_id')->references('id')->on('sucursals');
            $table->BigInteger('almacen_id')->unsigned()->nullable();
            $table->foreign('almacen_id')->references('id')->on('almacens');
            $table->BigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->BigInteger('proveeedor_id')->unsigned()->nullable();
            $table->foreign('proveeedor_id')->references('id')->on('proveedors');
            $table->BigInteger('documento_id')->unsigned()->nullable();
            $table->foreign('documento_id')->references('id')->on('documentos');
            $table->string('nume_doc')->nullable();
            $table->datetime('fecha');
            $table->decimal('acuenta',7,2);
            $table->decimal('saldo',7,2);
            $table->decimal('total',7,2);
            $table->string('estadoPagado',1)->default(1);
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
        Schema::dropIfExists('compras');
    }
};
