<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprobantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobantes', function (Blueprint $table) {
            $table->id();
            $table->string('nrotramite')->default('');
            $table->string('nrocomrobante')->default('');
            $table->date('fecha');
            $table->string('tipo')->default('');
            $table->string('codigo')->default('');
            $table->string('valorcatastral')->default('');
            $table->string('mtsfrte')->default('');
            $table->string('placa')->default('');
            $table->string('marca')->default('');
            $table->string('modelo')->default('');
            $table->string('padron')->default('');
            $table->string('capital')->default('');
            $table->string('varios')->default('');
            $table->string('tipopago')->default('');
            $table->string('banco')->default('');
            $table->string('banconro')->default('');
            $table->string('intere')->default('');
            $table->string('multa')->default('');
            $table->string('otros')->default('');
            $table->string('formulario')->default('');
            $table->string('total')->default('');
            $table->string('literal')->default('');
            $table->string('controlinterno')->default('');
            $table->string('estado')->default('CREADO');
            $table->string('cajero')->default('');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            
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
        Schema::dropIfExists('comprobantes');
    }
}
