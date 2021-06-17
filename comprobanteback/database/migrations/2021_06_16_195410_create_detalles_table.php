<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles', function (Blueprint $table) {
            $table->id();
            $table->string('coditem')->default('');
            $table->string('nombreitem')->default('');
            $table->string('codsubitem')->default('');
            $table->string('nombresubitem')->default('');
            $table->string('subtotal')->default('');
            $table->unsignedBigInteger('comprobante_id');
            $table->foreign('comprobante_id')->references('id')->on('comprobantes');
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
        Schema::dropIfExists('detalles');
    }
}
