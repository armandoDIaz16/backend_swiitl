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

        $anteproyecto->NOMBRE = $request->Nombre;
        $anteproyecto->PDF = $request->pdf;
        $anteproyecto->ALUMNO = $request->Alumno;
        $anteproyecto->ESTATUS = '1';
        $anteproyecto->AREA_ACADEMICA = $request->AreaAcademica;
        $anteproyecto->AUTOR = $request->Autor;
        $anteproyecto->EMPRESA = $request->Empresa;
        $anteproyecto->TIPO_ESPECIALIDAD = $request->TipoEspecialidad;
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
        return AnteproyectoResidencias::where('ID_ANTEPROYECTO',$id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return AnteproyectoResidencias::where('ID_ANTEPROYECTO',$id)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ID_ANTEPROYECTO)
    {
        $anteproyecto = AnteproyectoResidencias::where('ID_ANTEPROYECTO',$ID_ANTEPROYECTO)->first();

        //$carga = new CargaArchivo();

            if($request->Nombre) {
                $anteproyecto->NOMBRE = $request->Nombre;
            }
            if($request->pdf){
                //$ruta = $carga->savefile($request);
                //$anteproyecto->pdf = $ruta;
            }
            if($request->Alumno){
                $x = $request->Alumno;
                $etse = AnteproyectoResidencias::where('ALUMNO',$x)->first();
                if($anteproyecto->Alumno != 'NULL'){
                    if($etse == NULL){
                        $anteproyecto->ALUMNO = $x;
                        //return $f = json_encode('ok');
                    }
                    else ;//return $i = json_encode('Un alumno no puede tener más de un proyecto.');
                }
                else ;//return  $h = json_encode('Proyecto ya esta asignado a un alumno.');
                //$anteproyecto->Alumno = $request->Alumno;
            }
            if($request->Estatus){
                $anteproyecto->ESTATUS = $request->Estatus;
            }
            if($request->AreaAcademica){
                $anteproyecto->AREA_ACADEMICA = $request->AreaAcademica;
            }
            if($request->Autor){
                $anteproyecto->AUTOR = $request->Autor;
            }
            if($request->Empresa){
                $anteproyecto->EMPRESA = $request->Empresa;
            }
            if($request->TipoEspecialidad){
                $anteproyecto->TIPO_ESPECIALIDAD = $request->TipoEspecialidad;
            }
            if($request->Cancelar){
                $anteproyecto->ALUMNO = NULL;
            }
        $anteproyecto->save();
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

    public function alumno($id)
    {
        return AnteproyectoResidencias::where('ALUMNO',$id)->get();
    }

    public function proyecto(Request $request){
        $ALUMNO = $request->id;
        $anteproyecto = AnteproyectoResidencias::where('ALUMNO',$ALUMNO)->first();
        $carga = new CargaArchivo();
        $ruta = $carga->savefile($request);
        $anteproyecto->PDF = $ruta;
        try{
        $anteproyecto->save();
        return json_encode('Guardado con exito!');}
        catch(\Exception $exception){
            return json_encode('Error al subir archivo');
        }
    }
}
