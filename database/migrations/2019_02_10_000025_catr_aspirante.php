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
            $table->increments('PK_ASPIRANTE');

            /* DATOS GENERALES */
            $table->char('PREFICHA',10);
            $table->integer('NUMERO_PREFICHA');
            $table->string('PADRE_TUTOR')->nullable();
            $table->string('MADRE')->nullable();
            $table->string('ESPECIALIDAD')->nullable();
            $table->decimal('PROMEDIO', 3, 1);	
            $table->string('NACIONALIDAD');
            $table->char('TRABAJAS_Y_ESTUDIAS',1)->default(0);
            $table->char('AVISO_PRIVACIDAD',1)->default(0);
            $table->string('AYUDA_INCAPACIDAD')->nullable()->comment("Refiere al tipo de ayuda que necesita para atender la incapacidad");


            /* CLAVES FORANEAS */
            $table->integer('FK_PERIODO');
            $table->foreign('FK_PERIODO')->references('PK_PERIODO_PREFICHAS')->on('CAT_PERIODO_PREFICHAS');

            $table->integer('FK_BACHILLERATO')->nullable();
            $table->foreign('FK_BACHILLERATO')->references('PK_BACHILLERATO')->on('CAT_BACHILLERATO');

            $table->integer('FK_CARRERA_1');
            $table->foreign('FK_CARRERA_1')->references('PK_CARRERA')->on('CATR_CARRERA');

            $table->integer('FK_CARRERA_2')->nullable();
            $table->foreign('FK_CARRERA_2')->references('PK_CARRERA')->on('CATR_CARRERA');

            $table->integer('FK_PADRE');
            $table->foreign('FK_PADRE')->references('PK_USUARIO')->on('users');

            $table->integer('FK_DEPENDENCIA');
            $table->foreign('FK_DEPENDENCIA')->references('PK_DEPENDENCIA')->on('CAT_DEPENDENCIA');

            $table->integer('FK_CIUDAD')->nullable();
            $table->foreign('FK_CIUDAD')->references('PK_CIUDAD')->on('CATR_CIUDAD');

            $table->integer('FK_UNIVERSIDAD')->nullable();
            $table->foreign('FK_UNIVERSIDAD')->references('PK_UNIVERSIDAD')->on('CAT_UNIVERSIDAD');

            $table->integer('FK_CARRERA_UNIVERSIDAD')->nullable();
            $table->foreign('FK_CARRERA_UNIVERSIDAD')->references('PK_CARRERA_UNIVERSIDAD')->on('CAT_CARRERA_UNIVERSIDAD');

            $table->integer('FK_PROPAGANDA_TECNOLOGICO');
            $table->foreign('FK_PROPAGANDA_TECNOLOGICO')->references('PK_PROPAGANDA_TECNOLOGICO')->on('CAT_PROPAGANDA_TECNOLOGICO');

            $table->integer('FK_ESTATUS')->nullable();
            $table->foreign('FK_ESTATUS')->references('PK_ESTATUS_ASPIRANTE')->on('CAT_ESTATUS_ASPIRANTE');


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
        Schema::dropIfExists('CATR_ASPIRANTE');
    }
}
