<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* $carreras = DB::table('TR_CARRERA_CAMPUS')
            ->select(DB::raw("TR_CARRERA_CAMPUS.PK_CARRERA_CAMPUS as PK_CARRERA, CAT_CARRERA.NOMBRE+' CAMPUS ' +CAT_CAMPUS.NOMBRE as NOMBRE"))
            ->join('CAT_CAMPUS', 'CAT_CAMPUS.PK_CAMPUS', '=',  'TR_CARRERA_CAMPUS.FK_CAMPUS')
            ->join('CAT_CARRERA', 'CAT_CARRERA.PK_CARRERA', '=',  'TR_CARRERA_CAMPUS.FK_CARRERA')
            ->where('TR_CARRERA_CAMPUS.ESTADO', 1)
            ->get(); */
        $carreras = DB::table('CAT_CARRERA')
            ->select('PK_CARRERA','NOMBRE')
            ->get();
        
        return $carreras;
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
    public function show($periodo)
    {
        $carreras = DB::table('TR_CARRERA_CAMPUS as TCC')
            ->select(DB::raw("TCC.PK_CARRERA_CAMPUS as PK_CARRERA, C.NOMBRE+' CAMPUS ' +CC.NOMBRE as NOMBRE"))
            ->join('CAT_CAMPUS as CC', 'TCC.FK_CAMPUS', '=', 'CC.PK_CAMPUS')
            ->join('CAT_CARRERA as C',  'TCC.FK_CARRERA', '=', 'C.PK_CARRERA')
            ->join('CATR_CARRERAS_PERIODO as CCP', 'C.PK_CARRERA', '=', 'CCP.FK_CARRERA')
            ->leftJoin('CAT_ASPIRANTE as CA', 'TCC.PK_CARRERA_CAMPUS', '=', 'CA.FK_CARRERA_1')
            ->join(
                DB::raw(
                    "(select C2.PK_CARRERA, COUNT(CA2.FK_CARRERA_1) AS CANTIDAD " .
                        "FROM TR_CARRERA_CAMPUS TCC2 " .
                        "join CAT_CARRERA C2 on TCC2.FK_CARRERA = C2.PK_CARRERA " .
                        "join CATR_CARRERAS_PERIODO CCP2 on C2.PK_CARRERA = CCP2.FK_CARRERA " .
                        "LEFT JOIN (select FK_CARRERA_1 FROM CAT_ASPIRANTE WHERE FK_ESTATUS > 1 ) CA2 on TCC2.PK_CARRERA_CAMPUS = CA2.FK_CARRERA_1 " .
                        "WHERE TCC2.ESTADO = " . 1 . " and CCP2.FK_PERIODO = " . $periodo .
                        "GROUP BY PK_CARRERA, CANTIDAD) as B"
                ),
                'B.PK_CARRERA',
                '=',
                'C.PK_CARRERA'
            )
            ->where([
                ['TCC.ESTADO', 1],
                ['CCP.FK_PERIODO', $periodo]
            ])
            ->whereRaw('CCP.CANTIDAD > B.CANTIDAD')
            ->groupBy('TCC.PK_CARRERA_CAMPUS', 'C.NOMBRE', 'CC.NOMBRE', 'C.PK_CARRERA', 'CCP.CANTIDAD')
            ->get();

        return  $carreras;
    }

    /*     SELECT TCC.PK_CARRERA_CAMPUS, C.NOMBRE, CC.NOMBRE, C.PK_CARRERA, CCP.CANTIDAD
FROM TR_CARRERA_CAMPUS TCC
join CAT_CAMPUS CC on TCC.FK_CAMPUS = CC.PK_CAMPUS
join CAT_CARRERA C on TCC.FK_CARRERA = C.PK_CARRERA
join CATR_CARRERAS_PERIODO CCP on C.PK_CARRERA = CCP.FK_CARRERA
LEFT JOIN CAT_ASPIRANTE CA on TCC.PK_CARRERA_CAMPUS = CA.FK_CARRERA_1
join (
    SELECT C2.PK_CARRERA, COUNT(CA2.FK_CARRERA_1) AS CANTIDAD
FROM TR_CARRERA_CAMPUS TCC2
join CAT_CARRERA C2 on TCC2.FK_CARRERA = C2.PK_CARRERA
join CATR_CARRERAS_PERIODO CCP2 on C2.PK_CARRERA = CCP2.FK_CARRERA
LEFT JOIN CAT_ASPIRANTE CA2 on TCC2.PK_CARRERA_CAMPUS = CA2.FK_CARRERA_1
WHERE TCC2.ESTADO = 1  AND CCP2.FK_PERIODO = 1
GROUP BY PK_CARRERA, CANTIDAD
    ) B on  B.PK_CARRERA = C.PK_CARRERA
WHERE TCC.ESTADO = 1  AND CCP.FK_PERIODO = 1 AND CCP.CANTIDAD > B.CANTIDAD
GROUP BY TCC.PK_CARRERA_CAMPUS, C.NOMBRE, CC.NOMBRE, C.PK_CARRERA, CCP.CANTIDAD */

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
