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

            /* DATOS GENERALES */
            $table->string('NOMBRE');
            $table->string('PRIMER_APELLIDO');
            $table->string('SEGUNDO_APELLIDO')->nullable();
            $table->date('FECHA_NACIMIENTO');
            $table->string('CURP', 18)->unique();
            $table->smallInteger('ESTADO')->default(0);
            $table->string('TELEFONO_CASA');
            $table->string('TELEFONO_MOVIL')->nullable()->unique();
            $table->string('CORREO1')->unique();
            $table->string('CORREO2')->nullable();
            $table->string('CORREO_INSTITUCIONAL')->nullable();
            $table->string('CONTRASENIA')->nullable();
            $table->string('CALLE');
            $table->string('NUMERO_EXTERIOR');
            $table->string('NUMERO_INTERIOR')->nullable();
            $table->string('NACIONALIDAD')->nullable();
            $table->char('SEXO',1);
            $table->string('TIPO_SANGUINEO')->nullable();
            $table->string('NSS', 11)->nullable();
            $table->string('NOMBRE_CONTACTO')->nullable();
            $table->string('TELEFONO_CONTACTO')->nullable();
            $table->string('CORREO_CONTACTO')->nullable();
            $table->string('AYUDA_INCAPACIDAD')->nullable()->comment("Refiere al tipo de ayuda que necesita para atender la incapacidad");

            /* CLAVES FORANEAS */
            $table->integer('FK_COLONIA');
            $table->foreign('FK_COLONIA')->references('PK_COLONIA')->on('CATR_COLONIA');

            $table->integer('FK_INCAPACIDAD');
            $table->foreign('FK_INCAPACIDAD')->references('PK_INCAPACIDAD')->on('CAT_INCAPACIDAD');

            $table->integer('FK_ESTADO_CIVIL');
            $table->foreign('FK_ESTADO_CIVIL')->references('PK_ESTADO_CIVIL')->on('CAT_ESTADO_CIVIL');


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
        Schema::dropIfExists('catr_usuario');
    }
}
