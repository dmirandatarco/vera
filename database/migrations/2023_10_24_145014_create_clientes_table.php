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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('documento',50)->nullable();
            $table->string('num_documento',15)->nullable();
            $table->string('sunat',2)->nullable();
            $table->string('razon_social')->nullable();
            $table->string('nombre_comercial')->nullable();
            $table->string('telefono',50)->nullable();
            $table->string('direccion')->nullable();
            $table->string('correo')->nullable();
            $table->string('zona')->nullable();
            $table->string('tipo',10)->nullable();
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
        Schema::dropIfExists('clientes');
    }
};
