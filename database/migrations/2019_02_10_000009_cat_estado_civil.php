<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CatEstadoCivil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CAT_ESTADO_CIVIL', function (Blueprint $table) {
            /* CLAVES PRIMARIAS */
            $table->increments('PK_ESTADO_CIVIL');

            /* DATOS GENERALES */
            $table->string('NOMBRE');
            $table->smallInteger('ESTADO');

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
        Schema::dropIfExists('CAT_ESTADO_CIVIL');
    }
}
