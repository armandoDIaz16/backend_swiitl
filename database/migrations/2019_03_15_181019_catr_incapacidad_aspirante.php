<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CatrIncapacidadAspirante extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CATR_INCAPACIDAD_ASPIRANTE', function (Blueprint $table) {
            /* CLAVES PRIMARIAS */
            $table->increments('PK_INCAPACIDAD_ASPIRANTE');

            /* DATOS GENERALES */
            $table->string('AYUDA_INCAPACIDAD')->nullable()->comment("Refiere al tipo de ayuda que necesita para atender la incapacidad");

            /* CLAVES FORANEAS */
            $table->integer('FK_ASPIRANTE');
            $table->foreign('FK_ASPIRANTE')->references('PK_ASPIRANTE')->on('CATR_ASPIRANTE');

            $table->integer('FK_INCAPACIDAD1');
            $table->foreign('FK_INCAPACIDAD1')->references('PK_INCAPACIDAD')->on('CAT_INCAPACIDAD');
            $table->integer('FK_INCAPACIDAD2');
            $table->foreign('FK_INCAPACIDAD2')->references('PK_INCAPACIDAD')->on('CAT_INCAPACIDAD');
            $table->integer('FK_INCAPACIDAD3');
            $table->foreign('FK_INCAPACIDAD3')->references('PK_INCAPACIDAD')->on('CAT_INCAPACIDAD');
            $table->integer('FK_INCAPACIDAD4');
            $table->foreign('FK_INCAPACIDAD4')->references('PK_INCAPACIDAD')->on('CAT_INCAPACIDAD');
            $table->integer('FK_INCAPACIDAD5');
            $table->foreign('FK_INCAPACIDAD5')->references('PK_INCAPACIDAD')->on('CAT_INCAPACIDAD');

            /* DATOS DE AUDITORIA */
            $table->integer('FK_USUARIO_REGISTRO')->nullable();
            $table->dateTime('FECHA_REGISTRO')->useCurrent();
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
        Schema::dropIfExists('catr_incapacidad_aspirante');
    }
}
