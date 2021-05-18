<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleRutasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_rutas', function (Blueprint $table) {
            $table->id();
            $table->integer('orden');
            $table->integer('distancia_sig_ruta');
            $table->integer('distancia_ant_ruta');
            $table->foreignId('id_ruta')->constrained('rutas');
            $table->foreignId('id_estacion')->constrained('estaciones');
            $table->foreignId('id_acceso')->constrained('accesos');
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
        Schema::dropIfExists('detalle_rutas');
    }
}
