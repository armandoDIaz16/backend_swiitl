<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aspirante;
use App\Usuario;

class AspiranteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuario = new Usuario();
        $usuario->NOMBRE = $request->NOMBRE;
        $usuario->PRIMER_APELLIDO = $request->PRIMER_APELLIDO;
        $usuario->SEGUNDO_APELLIDO = $request->SEGUNDO_APELLIDO;
        $usuario->FECHA_NACIMIENTO = $request->FECHA_NACIMIENTO;
        $usuario->SEXO = $request->SEXO;
        $usuario->CURP = $request->CURP;
        $usuario->FK_ESTADO_CIVIL = $request->FK_ESTADO_CIVIL;
        $usuario->CALLE = $request->CALLE;
        $usuario->NUMERO_EXTERIOR = $request->NUMERO_EXTERIOR;
        $usuario->NUMERO_INTERIOR = $request->NUMERO_INTERIOR;
        $usuario->FK_COLONIA = $request->FK_COLONIA;
        $usuario->TELEFONO_CASA = $request->TELEFONO_CASA;
        $usuario->TELEFONO_MOVIL = $request->TELEFONO_MOVIL;
        $usuario->CORREO1 = $request->CORREO1;
        $usuario->FK_INCAPACIDAD = $request->FK_INCAPACIDAD;
        $usuario->AYUDA_INCAPACIDAD = $request->AYUDA_INCAPACIDAD;
        $usuario->save();

        //return Carrera_Universidad::select('PK_CARRERA_UNIVERSIDAD','NOMBRE')->get();

        $FK_PADRE = SWITLL::table('CATR_USUARIO')->insertGetId(
            ['CURP' => $usuario->CURP]
        );

        $aspirante = new Aspirante();
        $aspirante->PERIODO = $request->PERIODO;
        $aspirante->PADRE_TUTOR = $request->PADRE_TUTOR;
        $aspirante->MADRE = $request->MADRE;
        $aspirante->FK_BACHILLERATO = $request->FK_BACHILLERATO;
        $aspirante->ESPECIALIDAD = $request->ESPECIALIDAD;
        $aspirante->PROMEDIO = $request->PROMEDIO;
        $aspirante->NACIONALIDAD = $request->NACIONALIDAD;
        $aspirante->FK_CIUDAD = $request->FK_CIUDAD;
        $aspirante->FK_CARRERA_1 = $request->FK_CARRERA_1;
        $aspirante->FK_CARRERA_2 = $request->FK_CARRERA_2;
        $aspirante->FK_PROPAGANDA_TECNOLOGICO = $request->FK_PROPAGANDA_TECNOLOGICO;
        $aspirante->FK_CARRERA_UNIVERSIDAD = $request->FK_CARRERA_UNIVERSIDAD;
        $aspirante->FK_DEPENDENCIA = $request->FK_DEPENDENCIA;
        $aspirante->TRABAJAS_Y_ESTUDIAS = $request->TRABAJAS_Y_ESTUDIAS;
        $aspirante->AVISO_PRIVACIDAD = $request->AVISO_PRIVACIDAD;
        $aspirante->FK_PADRE = $FK_PADRE;
        $aspirante->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Usuario::where('PK_USUARIO', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
