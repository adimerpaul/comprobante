<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnuladosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anulados', function (Blueprint $table) {
            $table->id();
            $table->string('nrocomprobante');
            $table->date('fecha');
            $table->time('hora');
            $table->unsignedBigInteger('comprobante_id')->nullable()->default(1);
            $table->unsignedBigInteger('unid_id')->nullable()->default(16);
            $table->unsignedBigInteger('user_id')->nullable()->default(1);
            $table->foreign('comprobante_id')->references('id')->on('comprobantes');
            $table->foreign('unid_id')->references('id')->on('unids');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('anulados');
    }
}
