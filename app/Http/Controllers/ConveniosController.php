<?php

namespace App\Http\Controllers;

use App\Convenios;
use App\CargaArchivo;
use Illuminate\Http\Request;

class ConveniosController extends Controller
{
    public function index()
    {
        $empresa = Convenios::all();
        return $empresa;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $convenio = new Convenios();
        $convenio->NOMBRE_EMPRESA = $request->NombreEmpresa;
        $convenio->NOMBRE_REPRESENTANTE = $request->NombreRepresentante;
        $convenio->NO_ACTA_CONSTITUTIVA = $request->NoActaConstitutiva;
        $convenio->FECHA_FIRMA = $request->FechaFirma;
        $convenio->NOMBRE_NOTARIO = $request->NombreNotario;
        $convenio->NO_NOTARIA = $request->NoNotaria;
        $convenio->ENTIDAD_FEDERATIVA = $request->EntidadFederativa;
        $convenio->FECHA_REGISTRO_E = $request->FechaRegistro;
        $convenio->FOLIO_MERCANTIL = $request->FolioMercantil;
        $convenio->NO_VOLUMEN = $request->NoVolumen;
        $convenio->OBJETO_SOCIAL = $request->ObjetoSocial;
        $convenio->NO_ESCRITURA = $request->NoEscritura;
        $convenio->FECHA_NOTARIO = $request->FechaNotario;
        $convenio->NOMBRE_NOTARIO_NOTARIO = $request->NombreNotarioNotario;
        $convenio->NO_NOTARIA_NOTARIO = $request->NoNotariaNotario;
        $convenio->ENTIDAD_FEDERATIVA_NOTARIO = $request->EntidadFederativaNotario;
        $convenio->NO_RFC = $request->NoRFC;
        $convenio->DIR_EMPRESA = $request->DirEmpresa;
        $convenio->NOMBRE_TESTIGO = $request->NombreTestigo;
        $carga = new CargaArchivo();
        $ruta = $carga->savefile($request);
        $convenio->LOGO_EMPRESA = $ruta;
        try{
        $convenio->save();
            return json_encode('Guardado con exito!');}
        catch(\Exception $exception){
            return json_encode('Error al subir archivo');
        }


    }

    public function show($id)
    {
        //
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
