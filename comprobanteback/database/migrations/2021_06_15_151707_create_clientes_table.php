<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
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
            $table->string('ci')->default('')->unique();
            $table->string('expedido')->default('')->nullable();
            $table->string('paterno')->nullable()->default('');
            $table->string('materno')->nullable()->default('');
            $table->string('padron')->nullable()->default('');
            $table->string('nombre')->default('');
            $table->string('casada')->nullable()->default('');
            $table->string('direccion')->default('');
            $table->string('numcasa')->nullable()->default('');;
            $table->string('telefono')->nullable()->default('');;
            $table->boolean('estado')->default(true);
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
}
