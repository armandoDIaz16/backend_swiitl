<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('PK_USUARIO');
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();

            /* DATOS GENERALES */
           // $table->string('NOMBRE');
            $table->string('PRIMER_APELLIDO')->nullable();
            $table->string('SEGUNDO_APELLIDO')->nullable();
            $table->date('FECHA_NACIMIENTO')->nullable();
            $table->string('CURP', 18)->unique();
            $table->char('ESTADO',1)->default(0);
            $table->string('TELEFONO_CASA')->nullable();
            $table->string('TELEFONO_MOVIL')->nullable();
            $table->string('CORREO1')->nullable();
            $table->string('CORREO2')->nullable();
            $table->string('CORREO_INSTITUCIONAL')->nullable();
            //$table->string('CONTRASENIA')->nullable();
            $table->string('CALLE')->nullable();
            $table->integer('NUMERO_EXTERIOR')->nullable();
            $table->integer('NUMERO_INTERIOR')->nullable();
            $table->string('NACIONALIDAD')->nullable();
            $table->char('SEXO',1)->nullable();
            $table->string('TIPO_SANGUINEO')->nullable();
            $table->string('NSS', 11)->nullable();
            $table->string('NOMBRE_CONTACTO')->nullable();
            $table->string('TELEFONO_CONTACTO')->nullable();
            $table->string('CORREO_CONTACTO')->nullable();
            
            /* CLAVES FORANEAS */
            $table->integer('FK_COLONIA')->nullable();
            $table->foreign('FK_COLONIA')->references('PK_COLONIA')->on('CATR_COLONIA')->nullable();

            $table->integer('FK_ESTADO_CIVIL')->nullable();
            $table->foreign('FK_ESTADO_CIVIL')->references('PK_ESTADO_CIVIL')->on('CAT_ESTADO_CIVIL')->nullable();


            /* DATOS DE AUDITORIA */
            $table->integer('FK_USUARIO_REGISTRO')->nullable();
            $table->dateTime('FECHA_REGISTRO')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('FK_USUARIO_MODIFICACION')->nullable();
            $table->dateTime('FECHA_MODIFICACION')->nullable();
            $table->char('BORRADO',1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
