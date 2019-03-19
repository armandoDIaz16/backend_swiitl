<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CATRCODIGOPOSTAL extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('CATR_CODIGO_POSTAL', function (Blueprint $table) {

            /* CLAVES PRIMARIAS */
            $table->integer('PK_NUMERO_CODIGO_POSTAL')->primary();

            /* DATOS GENERALES */

            /* CLAVES FORANEAS */
            $table->integer('FK_CIUDAD');
            $table->foreign('FK_CIUDAD')
                  ->references('PK_CIUDAD')->on('CATR_CIUDAD');

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
        Schema::dropIfExists('CATR_CODIGO_POSTAL');
    }
}
