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
        Schema::create('institucion', function (Blueprint $table) {
            $table->id();

            $table->string('nombre')->unique();
            $table->string('direccion');
            $table->string('contacto');
            $table->string('responsable');
            $table->string('codigo_id')->unique();
            $table->string('email');
            $table->string('telefono');
            $table->string('image', 50)->nullable();

            $table->enum('status', ['ACTIVO', 'BLOQUEADO'])->default('ACTIVO');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('localidad_id');
            $table->foreign('localidad_id')->references('id')->on('localidades');
            $table->json('detalle_codificacion')->nullable();
            $table->json('ejemplo_codificacion')->nullable();
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
        Schema::dropIfExists('institucion');
    }
};
