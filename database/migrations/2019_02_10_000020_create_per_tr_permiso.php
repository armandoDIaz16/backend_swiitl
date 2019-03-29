<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerTrPermiso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PER_TR_PERMISO', function (Blueprint $table) {
            /* CLAVES PRIMARIAS */
            $table->increments('PK_PERMISO');

            /* CLAVES FORANEAS */
            $table->integer('FK_ROL');
            $table->foreign('FK_ROL')->references('PK_ROL')->on('PER_CATR_ROL');

            $table->integer('FK_ACCION');
            $table->foreign('FK_ACCION')->references('PK_ACCION')->on('PER_CATR_ACCION');

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
        Schema::dropIfExists('per_tr_permiso');
    }
}
