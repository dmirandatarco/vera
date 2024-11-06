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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('sucursal_id')->unsigned()->nullable();
            $table->foreign('sucursal_id')->references('id')->on('sucursals');
            $table->BigInteger('almacen_id')->unsigned()->nullable();
            $table->foreign('almacen_id')->references('id')->on('almacens');
            $table->BigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->BigInteger('cliente_id')->unsigned()->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->BigInteger('documento_id')->unsigned()->nullable();
            $table->foreign('documento_id')->references('id')->on('documentos');
            $table->string('nume_doc')->nullable();
            $table->datetime('fecha');
            $table->decimal('acuenta',7,2);
            $table->decimal('saldo',7,2);
            $table->decimal('total',7,2);
            $table->string('tipo',1)->default(1); //1. CON TRABAJO / 0. SIN TRABAJO
            $table->string('pago',1)->default(1); //1. CONTADO / 0. CREDITO
            $table->string('estadoPagado',1)->default(1);
            $table->string('sunat',1)->default(0); //1. ACEPTADO / 0. RECHAZADO / 2. ANULADO
            $table->string('facturado',1)->default(0); //1. Añadido / 0. sin ser añadido
            $table->string('facturacion',1)->default(0); //1. desde Facutracion / 0. venta normal
            $table->string('descripcion',500)->nullable();
            $table->string('code_note',2)->nullable();
            $table->BigInteger('factura_id')->unsigned()->nullable();
            $table->foreign('factura_id')->references('id')->on('ventas');
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
        Schema::dropIfExists('ventas');
    }
};
