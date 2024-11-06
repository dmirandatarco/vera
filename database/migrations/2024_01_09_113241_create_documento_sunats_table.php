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
        Schema::create('documento_sunats', function (Blueprint $table) {
            $table->id();
            $table->text('xml')->nullable();
            $table->text('hash')->nullable();
            $table->boolean('respuesta',1)->nullable();
            $table->text('codeError')->nullable();
            $table->text('messageError')->nullable();
            $table->text('cdrZip')->nullable();
            $table->text('codeCdr')->nullable();
            $table->text('descripcionCdr')->nullable();
            $table->text('notesCdr')->nullable();
            $table->BigInteger('venta_id')->unsigned();
            $table->foreign('venta_id')->references('id')->on('ventas');
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
        Schema::dropIfExists('documento_sunats');
    }
};
