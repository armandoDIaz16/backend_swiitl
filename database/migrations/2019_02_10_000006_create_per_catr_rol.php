<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerCatrRol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PER_CATR_ROL', function (Blueprint $table) {
            /* CLAVES PRIMARIAS */
            $table->increments('PK_ROL');

            /* DATOS GENERALES */
            $table->string('NOMBRE');
            $table->smallInteger('ESTADO');

            /* CLAVES FORANEAS */
            $table->integer('FK_SISTEMA');
            $table->foreign('FK_SISTEMA')->references('PK_SISTEMA')->on('PER_CAT_SISTEMA');

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
        Schema::dropIfExists('per_catr_rol');
    }
}
