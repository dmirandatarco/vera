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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id')-> unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->BigInteger('medio_id')-> unsigned();
            $table->foreign('medio_id')->references('id')->on('medios');
            $table->BigInteger('venta_id')-> unsigned()->nullable();
            $table->foreign('venta_id')->references('id')->on('ventas');
            $table->BigInteger('compra_id')-> unsigned()->nullable();
            $table->foreign('compra_id')->references('id')->on('compras');
            $table->BigInteger('caja_id')-> unsigned()->nullable();
            $table->foreign('caja_id')->references('id')->on('cajas');
            $table->boolean('tipo')->default(1); //1. Ingreso, 2. Egreso
            $table->dateTime('fecha');
            $table->decimal('total',15,2);
            $table->string('documento')->nullable();
            $table->string('operacion')->nullable();
            $table->text('observacion')->nullable();
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
        Schema::dropIfExists('pagos');
    }
};
