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
        Schema::create('venta_venta', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('venta_id')-> unsigned();
            $table->foreign('venta_id')->references('id')->on('ventas');
            $table->BigInteger('ventas_id')-> unsigned();
            $table->foreign('ventas_id')->references('id')->on('ventas');
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
        Schema::dropIfExists('venta_venta');
    }
};
