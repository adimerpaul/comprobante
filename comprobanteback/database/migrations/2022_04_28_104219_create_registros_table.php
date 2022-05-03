<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            $table->string("temporada");
            $table->string("ubicacion");
            $table->string("coditem");
            $table->string("nombreitem");
            $table->string("coditemsubitem");
            $table->string("nombresubitem");
            $table->string("detalle");
            $table->string("largo");
            $table->string("ancho");
            $table->unsignedBigInteger("cliente_id");
            $table->foreign("cliente_id")->references("id")->on("clientes");
            $table->unsignedBigInteger("rubro_id");
            $table->foreign("rubro_id")->references("id")->on("rubros");
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
        Schema::dropIfExists('registros');
    }
}
