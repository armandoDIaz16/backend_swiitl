<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CATCARRERAUNIVERSIDAD extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CAT_CARRERA_UNIVERSIDAD', function (Blueprint $table) {
            /* CLAVES PRIMARIAS */
            $table->increments('PK_CARRERA_UNIVERSIDAD');

            /* DATOS GENERALES */
            $table->string('NOMBRE');

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
        Schema::dropIfExists('CAT_CARRERA_UNIVERSIDAD');
    }
}
