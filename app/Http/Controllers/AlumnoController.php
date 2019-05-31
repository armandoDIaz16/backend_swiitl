<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlumnoController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $alumnos = DB::select('DECLARE @Maestro int = :maestro
                                      SELECT users.name, users.PK_USUARIO 
                                      FROM users
                                      JOIN CAT_ANTEPROYECTO_RESIDENCIA ON users.PK_USUARIO = CAT_ANTEPROYECTO_RESIDENCIA.ALUMNO
                                      JOIN CATR_PROYECTO ON CAT_ANTEPROYECTO_RESIDENCIA.ID_ANTEPROYECTO = CATR_PROYECTO.FK_ANTEPROYECTO
                                      WHERE (CATR_PROYECTO.FK_DOCENTE = @Maestro
                                      OR CATR_PROYECTO.FK_ASESOR_EXT = @Maestro)',['maestro'=>$id]);
        return $alumnos;
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
