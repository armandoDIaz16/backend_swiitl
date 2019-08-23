<?php

namespace App\Http\Controllers;

use App\CreditosSiia;
use App\Mail\JuntaEmail;
use App\DocumentacionResidencias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CreditosSiiaController extends Controller
{

    public function index()
    {
        $var = new CreditosSiia();
        $varcon1 = $var->alumno2();
        $varcon2 = json_decode(json_encode($varcon1),true);
        for ($i=0;$i<count($varcon1);$i++) {
            $varcon3 = array_pop($varcon2);
            $id_padre = DB::select('SELECT ID_PADRE FROM CATR_ALUMNO WHERE NUMERO_CONTROL = :no', ['no' => $varcon3]);
            $id_padre1 = json_decode(json_encode($id_padre), true);
            $id_padre2 = array_pop($id_padre1);
            $id_padre3 = array_pop($id_padre2);
            DB::table('PER_TR_ROL_USUARIO')->insert(['FK_ROL' => '8', 'FK_USUARIO' => $id_padre3]);
            $documentacion = new Documentacion();
            $documentacion->ALUMNO = $id_padre3;
            $documentacion->PERIODO = $var->periodo();
            try{
            $documentacion->save();
            return response()->json('Alumnos habilitados');}
            catch(\Exception $exception){
                return response()->json('Error al habilitar');
            }
        }
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $var = new CreditosSiia();

        $distressCall = new \stdClass();
        $distressCall->demo_one = $request->Dia;
        $distressCall->demo_two = $request->Hora;
        $distressCall->demo_three = $request->Lugar;
        $distressCall->sender = $request->Persona;

        $varcor1 = $var->correo();
        $varcor2 = json_decode(json_encode($varcor1),true);

        for($i=0;$i<count($varcor1);$i++) {

            $varcoroller3 = array_pop($varcor2);

            $varcor4 = array_pop($varcor3);

            $varcor5 = array_pop($varcor4);

            Mail::to($varcor5)->send(new JuntaEmail($distressCall));
        }
    }


    public function show($id)
    {
        $var = new CreditosSiia();
        $varcon1 = $var->alumno2();
        $varcon2 = json_decode(json_encode($varcon1),true);
        for ($i=0;$i<count($varcon1);$i++) {
            $varcon3 = array_pop($varcon2);
            $residencias = $var->residencias($varcon3);
            if($residencias == null) {
                $id_padre = DB::select('SELECT ID_PADRE FROM CATR_ALUMNO WHERE NUMERO_CONTROL = :no', ['no' => $varcon3]);
                $id_padre1 = json_decode(json_encode($id_padre), true);
                $id_padre2 = array_pop($id_padre1);
                $id_padre3 = array_pop($id_padre2);
                DB::table('PER_TR_ROL_USUARIO')->where(['FK_ROL' => '8', 'FK_USUARIO' => $id_padre3])->delete();
                DB::table('CAT_DOCUMENTACION')->where('ALUMNO', $id_padre3)->delete();
            }
        }
        return response()->json('Alumnos deshabilitados exitosamente');

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
