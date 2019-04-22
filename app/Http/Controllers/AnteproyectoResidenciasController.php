<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CargaArchivo;
use App\AnteproyectoResidencias;

class AnteproyectoResidenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vistaante = AnteproyectoResidencias::all();
        return $vistaante;
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
        $anteproyecto = new AnteproyectoResidencias();

        $anteproyecto->Nombre = $request->Nombre;
        $anteproyecto->pdf = $request->pdf;
        $anteproyecto->Alumno = $request->Alumno;
        $anteproyecto->Estatus = $request->Estatus;
        $anteproyecto->AreaAcademica = $request->AreaAcademica;
        $anteproyecto->Autor = $request->Autor;
        $anteproyecto->Empresa = $request->Empresa;
        $anteproyecto->TipoEspecialidad = $request->TipoEspecialidad;
        $anteproyecto->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return AnteproyectoResidencias::where('id',$id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return AnteproyectoResidencias::where('id',$id)->get();
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
        $anteproyecto = AnteproyectoResidencias::find($id);

        $carga = new CargaArchivo();
        $x = $request->Usuario;


        $etse = AnteproyectoResidencias::where('Alumno',$x)->first();
        \Log::debug('Test var fails' . $etse . 'Hola');
        if($anteproyecto->Alumno != 'NULL'){
            if($etse == NULL){
                $anteproyecto->Alumno = $x;
                $anteproyecto->save();
                return $f = json_encode('ok');
            }
            else return $i = json_encode('Un alumno no puede tener más de un proyecto.');
        }
        else return  $h = json_encode('Proyecto ya esta asignado a un alumno.');

/*            if(!$request->Nombre):
                ;
            else:
                $anteproyecto->Nombre = $request->Nombre;
            endif;  ;
            if(!$request->pdf):
                ;
            else:
                $ruta = $carga->savefile($request);
                $anteproyecto->pdf = $ruta;
            endif;
            if(!$request->Alumno):
                ;
            else:
                $anteproyecto->Alumno = $request->Alumno;
            endif;
            if(!$request->Estatus):
                ;
            else:
                $anteproyecto->Estatus = $request->Estatus;
            endif;
            if(!$request->AreaAcademica):
                ;
            else:
                $anteproyecto->AreaAcademica = $request->AreaAcademica;
            endif;
            if(!$request->Autor):
                ;
            else:
                $anteproyecto->Autor = $request->Autor;
            endif;
            if(!$request->Empresa):
                ;
            else:
                $anteproyecto->Empresa = $request->Empresa;
            endif;
            if(!$request->TipoEspecialidad):
                ;
            else:
                $anteproyecto->TipoEspecialidad = $request->TipoEspecialidad;
            endif;*/

          //  $anteproyecto->save();
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
