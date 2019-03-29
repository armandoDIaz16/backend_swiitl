<?php

namespace App\Http\Controllers;

use App\CreditosSiia;
use App\Mail\JuntaEmail;
use Illuminate\Http\Request;

class CreditosSiiaController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $var = new CreditosSiia();
        $var2 = 'info';

        $varcor1 = $var->correo();
        $varcor2 = json_decode(json_encode($varcor1),true);

        for($i=0;$i<count($varcor1);$i++) {

            $varcor3 = array_pop($varcor2);

            $varcor4 = array_pop($varcor3);

            $varcor5 = array_pop($varcor4);

            Mail::to($varcor5)->send(new JuntaEmail($var2));
        }
            return 'correo enviado';
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
