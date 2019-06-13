<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrIncapacidadAspirante extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TR_INCAPACIDAD_ASPIRANTE', function (Blueprint $table) {
            /* CLAVES PRIMARIAS */
            $table->primary(['FK_ASPIRANTE', 'FK_INCAPACIDAD']);

            /* CLAVES FORANEAS */
            $table->integer('FK_ASPIRANTE');
            $table->foreign('FK_ASPIRANTE')->references('PK_ASPIRANTE')->on('CATR_ASPIRANTE');

            $table->integer('FK_INCAPACIDAD');
            $table->foreign('FK_INCAPACIDAD')->references('PK_INCAPACIDAD')->on('CAT_INCAPACIDAD');

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
        Schema::dropIfExists('tr_incapacidad_aspirante');
    }
}
