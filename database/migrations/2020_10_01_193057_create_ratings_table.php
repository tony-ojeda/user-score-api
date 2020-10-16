<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // con relaciones polimorficas para el trabajo de la puntuación
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->float('score'); // guarda la puntuación
            /**
             * Para tablas polimorficas se rquiere el id y typo
             **/ 
             $table->morphs('rateable'); // hace referencia a la entidad que queremos puntuar
             //$table->unsignedBigInteger('rateable_id');
             //$table->string('rateable_type');
             $table->morphs('qualifier'); // para identificar la identidad que se esta calificando
             //$table->unsignedBigInteger('qualifier_id');
             //$table->string('qualifier_type');


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
        Schema::dropIfExists('ratings');
    }
}
