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
        $anteproyecto = new AnteproyectoResidencias();
        $carga = new CargaArchivo();
        $anteproyecto->Nombre = $request->Nombre;
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
        endif;
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


            if(!$request->Nombre):
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
            endif;

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
}
