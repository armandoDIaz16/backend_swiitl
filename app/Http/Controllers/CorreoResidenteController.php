<?php

namespace App\Http\Controllers;

use App\CorreoResidente;
use Illuminate\Http\Request;

class CorreoResidenteController extends Controller
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
        $var = new CorreoResidente();

        $distressCall = new \stdClass();
        $distressCall->demo_one = $request->Dia;
        $distressCall->demo_two = $request->Hora;
        $distressCall->demo_three = $request->Lugar;
        $distressCall->sender = $request->Persona;

        $id = $request->id;

        $varcor1 = $var->correo($id);
        $varcor2 = json_decode(json_encode($varcor1),true);

        for($i=0;$i<count($varcor1);$i++) {

            $varcor3 = array_pop($varcor2);

            $varcor4 = array_pop($varcor3);

            $varcor5 = array_pop($varcor4);

            Mail::to($varcor5)->send(new JuntaEmail($distressCall));
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
