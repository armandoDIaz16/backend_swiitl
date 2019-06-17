<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatrCarrera extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CATR_CARRERA', function (Blueprint $table) {
            /* CLAVES PRIMARIAS */
            $table->increments('PK_CARRERA');

            /* DATOS GENERALES */
            $table->string('CLAVE');
            $table->string('NOMBRE');
            $table->string('CAMPUS');
            $table->smallInteger('ESTADO');

            /* CLAVES FORANEAS */
            $table->integer('FK_AREA_ACADEMICA');
            $table->foreign('FK_AREA_ACADEMICA')->references('PK_AREA_ACADEMICA')->on('CAT_AREA_ACADEMICA');

            /* DATOS DE AUDITORIA */
            $table->integer('FK_USUARIO_REGISTRO')->nullable();
            $table->dateTime('FECHA_REGISTRO')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('FK_USUARIO_MODIFICACION')->nullable();
            $table->dateTime('FECHA_MODIFICACION')->nullable();
            $table->char('BORRADO',1)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catr_carrera');
    }
}
