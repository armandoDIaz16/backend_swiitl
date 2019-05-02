<?php

namespace App\Http\Controllers;

use App\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocenteController extends Controller
{
    public function index()
    {

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
        $x = Docente::select('ID_AREA_ACADEMICA')->where('ID_PADRE',$id)->first();
        $y = $x->ID_AREA_ACADEMICA;
        $nombre = DB::select('select PK_USUARIO, name from users join CATR_DOCENTE on users.PK_USUARIO = CATR_DOCENTE.ID_PADRE where ID_AREA_ACADEMICA = :area',['area'=>$y]);
        return $nombre;
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
