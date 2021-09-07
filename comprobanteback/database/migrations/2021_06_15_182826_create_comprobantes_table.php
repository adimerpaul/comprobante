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
            $table->string('nrotramite')->default('')->nullable();
            $table->string('nrocomprobante')->default('')->nullable();
            $table->date('fecha')->nullable();
            $table->date('fechalimite')->nullable();
            $table->dateTime('fechapago')->nullable();
            $table->dateTime('fechaimpreso')->nullable();
            $table->string('tipo')->default('')->nullable();
            $table->string('item')->default('')->nullable();
            $table->string('codigo')->default('')->nullable();
            $table->string('valorcatastral')->default('')->nullable();
            $table->string('mtsfrte')->default('')->nullable();
            $table->string('placa')->default('')->nullable();
            $table->string('marca')->default('')->nullable();
            $table->string('modelo')->default('')->nullable();
            $table->string('padron')->default('')->nullable();
            $table->string('capital')->default('')->nullable();
            $table->string('varios')->default('')->nullable();
            $table->string('tipopago')->default('')->nullable();
            $table->string('banco')->default('')->nullable();
            $table->string('banconro')->default('')->nullable();
            $table->string('intere')->default('')->nullable();
            $table->string('multa')->default('')->nullable();
            $table->string('otros')->default('')->nullable();
            $table->string('formulario')->default('')->nullable();
            $table->string('total')->default('')->nullable();
            $table->string('literal')->default('')->nullable();
            $table->string('controlinterno')->default('')->nullable();
            $table->string('estado')->default('CREADO')->nullable();
            $table->string('cajero')->default('')->nullable();
            $table->string('usuarioimp')->default('')->nullable();
            $table->string('anulado')->default('')->nullable();
            $table->boolean('porcaja')->default(false);
            $table->boolean('verificadocaja')->default(false);
            $table->dateTime('fechacaja')->nullable();

            $table->foreign('verificadocaja_id')->references('id')->on('users');
            $table->unsignedBigInteger('verificadocaja_id')->nullable()->default(NULL);
            
            $table->boolean('verificadosistema')->default(false);
            $table->date('fechasistema')->nullable();

            $table->foreign('verificadosistema_id')->references('id')->on('users');
            $table->unsignedBigInteger('verificadosistema_id')->nullable()->default(NULL);

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('cajero_id')->nullable()->default(NULL);
            $table->foreign('cajero_id')->references('id')->on('users');
            $table->unsignedBigInteger('impreso_id')->nullable()->default(NULL);
            $table->foreign('impreso_id')->references('id')->on('users');
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->unsignedBigInteger('unid_id');
            $table->foreign('unid_id')->references('id')->on('unids');
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
