<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrRestableceContrasena extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TR_RESTABLECE_CONTRASENA', function (Blueprint $table) {
            /* CLAVES PRIMARIAS */
            $table->increments('PK_RESTABLECE_CONTRASENA');

            /* DATOS GENERALES */
            $table->dateTime('FECHA_GENERACION');
            $table->dateTime('FECHA_EXPIRACION');
            $table->string('TOKEN');
            $table->smallInteger('ESTADO')->comment('Activo = 1, Utilizado = 2');

            /* CLAVES FORANEAS */
            $table->integer('FK_USUARIO');
            $table->foreign('FK_USUARIO')->references('PK_USUARIO')->on('users');

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
        Schema::dropIfExists('tr_recupera_contrasena');
    }
}
