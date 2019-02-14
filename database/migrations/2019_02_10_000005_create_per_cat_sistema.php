<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerCatSistema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PER_CAT_SISTEMA', function (Blueprint $table) {
            /* CLAVES PRIMARIAS */
            $table->increments('PK_SISTEMA');

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
        Schema::dropIfExists('per_cat_sistema');
    }
}
