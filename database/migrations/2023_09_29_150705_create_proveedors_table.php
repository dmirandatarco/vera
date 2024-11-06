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
        Schema::create('proveedors', function (Blueprint $table) {
            $table->id();
            $table->string('documento',15)->nullable();
            $table->string('num_documento',15)->nullable();
            $table->string('nombre',200)->nullable();
            $table->string('celular',9)->nullable();
            $table->text('direccion')->nullable();
            $table->text('correo')->nullable();
            $table->text('nrocuenta1')->nullable();
            $table->text('nrocuenta2')->nullable();
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
        Schema::dropIfExists('proveedors');
    }
};
