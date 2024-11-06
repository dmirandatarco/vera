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
        Schema::create('detalle_movimiento', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('movimiento_id')->unsigned();
            $table->foreign('movimiento_id')->references('id')->on('movimientos');
            $table->BigInteger('producto_id')->unsigned();
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->integer('cantidad')->nullable();
            $table->decimal('precio', 11, 2)->nullable();
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
        Schema::dropIfExists('detalle_movimiento');
    }
};
