<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerTrRolModulo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PER_TR_ROL_MODULO', function (Blueprint $table) {
            /* CLAVES PRIMARIAS */
            $table->increments('PK_ROL_MODULO');

            /* CLAVES FORANEAS */
            $table->integer('FK_ROL');
            $table->foreign('FK_ROL')->references('PK_ROL')->on('PER_CATR_ROL');

            $table->integer('FK_MODULO');
            $table->foreign('FK_MODULO')->references('PK_MODULO')->on('PER_CAT_MODULO');

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
        Schema::dropIfExists('per_tr_rol_modulo');
    }
}
