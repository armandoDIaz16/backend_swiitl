<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CATENTIDADFEDERATIVA extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CAT_ENTIDAD_FEDERATIVA', function (Blueprint $table) {
            
            /* CLAVES PRIMARIAS */
            $table->increments('PK_ENTIDAD_FEDERATIVA');

            /* DATOS GENERALES */
            $table->string('NOMBRE');

            /* CLAVES FORANEAS */

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
        Schema::dropIfExists('CAT_ENTIDAD_FEDERATIVA');
    }
}
