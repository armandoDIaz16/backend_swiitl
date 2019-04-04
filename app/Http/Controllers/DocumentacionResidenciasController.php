<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CargaArchivo;
use App\DocumentacionResidencias;
use Illuminate\Support\Facades\Log;

class DocumentacionResidenciasController extends Controller
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
       $carga = new CargaArchivo();
       return $carga->saveFile($request);
        /* $documentacion = new Documentacion();
        $documentacion->id_alumno = $request->id_alumno;
        $documentacion->save();*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Return DocumentacionResidencias::where('id_alumno',$id)->get();
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
        $documentacion = DocumentacionResidencias::find($id);
        $carga = new CargaArchivo();


        if($request->id == 1):
            $ruta = $carga->savefile($request);
            $documentacion->carta_documentacion = $ruta;
        else:
            $ruta = $carga->savefile($request);
            $documentacion->carta_aceptacion = $ruta;
        endif;
            $documentacion->save();
    }


    public function updatechido(Request $request){
        //$documentacion = DocumentacionResidencias::find($id);

        $File = $request -> file('myfile'); //line 1
        $sub_path = 'files'; //line 2
        $real_name = $File -> getClientOriginalName(); //line 3
        $destination_path = public_path($sub_path);  //line 4
        $File->move($destination_path,  $real_name);  //line 5
        return response()->json('Solicitud guardada');
    }

    public function updateaceptacion(Request $request){
        //$documentacion = DocumentacionResidencias::find($id);

        $File = $request -> file('myfile'); //line 1
        $sub_path = 'files'; //line 2
        $real_name = $File -> getClientOriginalName(); //line 3
        $destination_path = public_path($sub_path);  //line 4
        $File->move($destination_path,  $real_name);  //line 5
        return response()->json('Carta de aceptacion guardada');
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
