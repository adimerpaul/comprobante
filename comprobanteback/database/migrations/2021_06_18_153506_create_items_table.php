<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->string('nombre')->nullable();
            $table->string('detalle')->nullable();
            $table->double('monto',11,2)->nullable();
            $table->string('estado')->nullable()->default('ACTIVO');
            $table->unsignedBigInteger('itempadre_id')->nullable()->default(1);
            $table->foreign('itempadre_id')->references('id')->on('itempadres');
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
        Schema::dropIfExists('items');
    }
}
