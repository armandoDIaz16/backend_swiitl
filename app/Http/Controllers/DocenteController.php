<?php

namespace App\Http\Controllers;

use App\CreditosSiia;
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
        $periodo = new CreditosSiia();
        $actual = $periodo->periodo();
        $nombre = DB::select('select PK_USUARIO, NOMBRE from CAT_USUARIO join CATR_DOCENTE on CAT_USUARIO.PK_USUARIO = CATR_DOCENTE.ID_PADRE where ID_AREA_ACADEMICA = :area'
        ,['area'=>$y]);
        foreach ($nombre as $index => $value) {
            $no = $value->PK_USUARIO;
            $nom = DB::select('SELECT COUNT(PK_PROYECTO) FROM CATR_PROYECTO WHERE FK_DOCENTE = :docente and PERIODO = :periodo',['docente'=>$no, 'periodo'=>$actual]);
            $t = json_decode(json_encode($nom), true);
            $t2 = array_pop($t);
            $t3 = array_pop($t2);
            $value->CANTIDAD = $t3;
        }
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
