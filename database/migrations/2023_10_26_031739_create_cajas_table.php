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
        Schema::create('cajas', function (Blueprint $table) {
            $table->id();
            $table->datetime('fechaApertura')->nullable();
            $table->decimal('totalApertura',7,2)->nullable()->default(0);
            $table->datetime('fechaCierre')->nullable();
            $table->decimal('totalCierre',7,2)->nullable()->default(0);
            $table->decimal('totalGlobalEfectivo',10,2)->nullable()->default(0);
            $table->decimal('totalGlobalTransferencia',10,2)->nullable()->default(0);
            $table->boolean('estado')->default(1); //1. Apertura - 0. Cierre
            $table->BigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->BigInteger('sucursal_id')->unsigned();
            $table->foreign('sucursal_id')->references('id')->on('sucursals');
            $table->string('observacion')->nullable();
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
        Schema::dropIfExists('cajas');
    }
};
