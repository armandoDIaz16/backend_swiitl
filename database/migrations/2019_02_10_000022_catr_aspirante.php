<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CATRASPIRANTE extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CATR_ASPIRANTE', function (Blueprint $table) {

            /* CLAVES PRIMARIAS */
            $table->increments('PK_NUMERO_PREFICHA');

            /* DATOS GENERALES */
            $table->string('PADRE_TUTOR');
            $table->string('MADRE');
            $table->integer('PROMEDIO');
            $table->date('PERIODO');
            $table->char('AVISO_PRIVACIDAD',1)->default(0);
            $table->char('ESTATUS_PAGO',1)->default(0);

            /* CLAVES FORANEAS */
            $table->integer('FK_BACHILLERATO')->nullable();
            $table->integer('FK_CARRERA_1');
            $table->integer('FK_CARRERA_2');
            $table->integer('FK_PADRE');
            $table->integer('FK_DEPENDENCIA');
            $table->foreign('FK_DEPENDENCIA')->references('PK_DEPENDENCIA')->on('CAT_DEPENDENCIA');
            $table->foreign('FK_BACHILLERATO')->references('PK_BACHILLERATO')->on('CAT_BACHILLERATO');
            $table->foreign('FK_CARRERA_1')->references('PK_CARRERA')->on('CATR_CARRERA');
            $table->foreign('FK_CARRERA_2')->references('PK_CARRERA')->on('CATR_CARRERA');
            $table->foreign('FK_PADRE')->references('PK_USUARIO')->on('CATR_USUARIO');

            /* DATOS DE AUDITORIA */
            $table->integer('FK_USUARIO_REGISTRO');
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
        Schema::dropIfExists('CATR_ASPIRANTE');
    }
}
