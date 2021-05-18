<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleRecorridosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_recorridos', function (Blueprint $table) {
            $table->id();
            $table->integer('cant_pasajeros')->nullable();
            $table->date('h_salida')->nullable();
            $table->date('h_entrada')->nullable();
             $table->foreignId('id_bus')->nullable()->constrained('buses');
              $table->foreignId('id_ruta')->constrained('rutas');
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
        Schema::dropIfExists('detalle_recorridos');
    }
}
