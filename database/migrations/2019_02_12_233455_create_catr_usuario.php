<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatrUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CATR_USUARIO', function (Blueprint $table) {
            /* CLAVES PRIMARIAS */
            $table->increments('PK_USUARIO');
            $table->primary('PK_USUARIO');

            /* DATOS GENERALES */
            $table->string('NOMBRE');
            $table->string('PRIMER_APELLIDO');
            $table->string('SEGUNDO_APELLIDO')->nullable();
            $table->date('FECHA_NACIMIENTO');
            $table->string('CURP', 18)->unique();
            $table->smallInteger('ESTADO');
            $table->string('TELEFONO_CASA');
            $table->string('TELEFONO_MOVIL')->unique();
            $table->string('CORREO1')->unique();
            $table->string('CORREO2')->unique();
            $table->string('CORREO_INSTITUCIONAL')->unique();
            $table->string('CONTRASENIA');
            $table->string('CALLE');
            $table->string('NUMERO_EXTERIOR');
            $table->string('NUMERO_INTERIOR')->nullable();
            $table->string('NACIONALIDAD');
            $table->char('SEXO');
            $table->string('TIPO_SANGUINEO');
            $table->string('NSS', 11)->unique();
            $table->string('NOMBRE_CONTACTO');
            $table->string('TELEFONO_CONTACTO');
            $table->string('CORREO_CONTACTO');
            $table->string('AYUDA_INCAPACIDAD')
                ->comment("Refiere al tipo de ayuda que necesita para atender la incapacidad");

            /* CLAVES FORANEAS */
            $table->integer('FK_COLONIA');
            $table->foreign('FK_COLONIA')->references('PK_COLONIA')->on('CAT_COLONIA');

            $table->integer('FK_INCAPACIDAD');
            $table->foreign('FK_INCAPACIDAD')->references('PK_INCAPACIDAD')->on('CAT_INCAPACIDAD');

            /* DATOS DE AUDITORIA */
            $table->integer('FK_USUARIO_REGISTRO');
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
        Schema::dropIfExists('catr_usuario');
    }
}
