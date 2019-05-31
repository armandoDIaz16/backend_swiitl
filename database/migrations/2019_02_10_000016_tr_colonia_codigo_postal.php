<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TRCOLONIACODIGOPOSTAL extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TR_COLONIA_CODIGO_POSTAL', function (Blueprint $table) {
            /* CLAVES PRIMARIAS */
            $table->primary(['FK_COLONIA', 'FK_NUMERO_CODIGO_POSTAL']);

            /* DATOS GENERALES */

            /* CLAVES FORANEAS */
            $table->integer('FK_COLONIA')->unsigned();
            $table->integer('FK_NUMERO_CODIGO_POSTAL')->unsigned();
            $table->foreign('FK_COLONIA')->references('PK_COLONIA')->on('CATR_COLONIA');
            $table->foreign('FK_NUMERO_CODIGO_POSTAL')->references('PK_NUMERO_CODIGO_POSTAL')->on('CATR_CODIGO_POSTAL');

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
        Schema::dropIfExists('CAT_COLONIA_CODIGO_POSTAL');
    }
}
