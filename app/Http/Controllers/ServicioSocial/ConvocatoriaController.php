<?php

namespace App\Http\Controllers\ServicioSocial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ServicioSocial\Convocatoria;
use App\ServicioSocial\DatoConvocatoria;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Edificio;
use App\Espacio;
use App\Campus;
use Mpdf\Mpdf;


class ConvocatoriaController extends Controller
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
        

    }
    public function saveConvocatoria(Request $request){
        $DATA = $request->json()->all();
        $convocatoria = new Convocatoria;
        $convocatoria->NO_CONTROL_CONV = $request->NO_CONTROL_CONV;
        $convocatoria->save();
        $fkActual  = $convocatoria->PK_CONVOCATORIA;
        if($fkActual){
            foreach($DATA['DATOS'] as $dato) {
                $datoConvocatoria = new DatoConvocatoria;
                $datoConvocatoria->FK_CONVOCATORIA = $fkActual;
                $datoConvocatoria->TURNO = $dato['TURNO'];
                $datoConvocatoria->FK_ESPACIO_CONVOCATORIA = $dato['FK_ESPACIO_CONVOCATORIA'];
                $datoConvocatoria->HORARIO_CONVOCATORIA = $dato['HORARIO_CONVOCATORIA'];
                $datoConvocatoria->FECHA_CONVOCATORIA = $dato['FECHA_CONVOCATORIA'];
                $datoConvocatoria->PERIODO = $dato['PERIODO'];
                $datoConvocatoria->save();
            }
            return 200;
        }else{
            return 500;
        }

        //error_log(print_r($request->datos, true));
            

    }

    public function getEspacio(){
        return Espacio::select('FK_EDIFICIO','FK_TIPO_ESPACIO','NOMBRE','IDENTIFICADOR','CAPACIDAD')->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Convocatoria::where('PK_CONVOCATORIA',$id)->get();
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

    public function getCampus($tecnm)
    {
        return DB::table('CAT_CAMPUS')
        ->join('CATR_TECNM','FK_TECNOLOGICO','=','PK_TECNOLOGICO')
        ->select('CAT_CAMPUS.PK_CAMPUS','CAT_CAMPUS.FK_TECNOLOGICO','CAT_CAMPUS.NOMBRE')
        ->where('FK_TECNOLOGICO','=',1)
        ->get();

        
    }

    public function getEdificios($campus){
        return DB::table('CATR_EDIFICIO')
        ->join('CAT_CAMPUS','FK_CAMPUS','=','PK_CAMPUS')
        ->select('PK_EDIFICIO','PREFIJO','FK_CAMPUS')
        ->where('FK_CAMPUS','=',$campus)
        ->get();  
    }

    public function getSalones($edifico)
    {
        return DB::table('CATR_ESPACIO')
        ->join('CATR_EDIFICIO','CATR_ESPACIO.FK_EDIFICIO','=','CATR_EDIFICIO.PK_EDIFICIO')
        ->select('PK_ESPACIO','FK_TIPO_ESPACIO','CATR_ESPACIO.NOMBRE','IDENTIFICADOR','CAPACIDAD')
        ->where('FK_EDIFICIO','=',$edifico)->get();
        
    }

    public function busquedaConvocatoria($dato){
        $busqueda;
        if(is_numeric($dato)){
            $busqueda = DB::select('SELECT C.PK_CONVOCATORIA, DC.FECHA_CONVOCATORIA,  E.NOMBRE, DC.PERIODO FROM CAT_CONVOCATORIA C
            JOIN CATR_DATO_CONVOCATORIA DC ON DC.FK_CONVOCATORIA = C.PK_CONVOCATORIA
            JOIN CATR_ESPACIO E ON E.PK_ESPACIO = DC.FK_ESPACIO_CONVOCATORIA
            WHERE DATEPART(year,DC.FECHA_CONVOCATORIA) = :dato', ['dato'=>$dato]);
        }
        else if($dato=='ENE-JUN' || $dato=='JUL-DIC'){

            $busqueda = DB::select('SELECT C.PK_CONVOCATORIA, DC.FECHA_CONVOCATORIA,  E.NOMBRE, DC.PERIODO FROM CAT_CONVOCATORIA C
            JOIN CATR_DATO_CONVOCATORIA DC ON DC.FK_CONVOCATORIA = C.PK_CONVOCATORIA
            JOIN CATR_ESPACIO E ON E.PK_ESPACIO = DC.FK_ESPACIO_CONVOCATORIA
            WHERE DC.PERIODO = :dato',['dato'=>$dato]);

        }else{
            $anio = substr($dato,0,4);
            $per = substr($dato,-7);
            $busqueda = DB::select('SELECT C.PK_CONVOCATORIA, DC.FECHA_CONVOCATORIA,  E.NOMBRE, DC.PERIODO FROM CAT_CONVOCATORIA C
            JOIN CATR_DATO_CONVOCATORIA DC ON DC.FK_CONVOCATORIA = C.PK_CONVOCATORIA
            JOIN CATR_ESPACIO E ON E.PK_ESPACIO = DC.FK_ESPACIO_CONVOCATORIA
            WHERE DC.PERIODO = :dato2 AND DATEPART(year,DC.FECHA_CONVOCATORIA) = :dato1',['dato1'=>$anio,'dato2'=>$per]);
        }
        return $busqueda;
        
    }

    public function allConvocatoria(){
            return DB::select('SELECT C.PK_CONVOCATORIA, DC.FECHA_CONVOCATORIA,  E.NOMBRE, DC.PERIODO FROM CAT_CONVOCATORIA C
            JOIN CATR_DATO_CONVOCATORIA DC ON DC.FK_CONVOCATORIA = C.PK_CONVOCATORIA
            JOIN CATR_ESPACIO E ON E.PK_ESPACIO = DC.FK_ESPACIO_CONVOCATORIA');
    }

    public function convocatoriaPdf($id){

        $pdf  = new Convocatoria();
        $datosC = $pdf->getDataConvocatoria($id);
            /*[NO_CONTROL_CONV] => 1424
            [PERIODO] => JUL-DIC
            [MES] => December
            [DIANu] => 31
            [DIANo] => Tuesday
            [ANIO] => 2019
            [TURNO] => Vespertino
            [NOMBRE_ESPACIO] => Laboratorio
            [NOMBRE_LUGAR] => C2
            [HORARIO] => 19:59-21:59 */
        $html_final = view('sSocial.convocatoria')->with('datosC',$datosC);

        $mpdf = new Mpdf([
            'orientation' => 'L',
            'margin_top' => 45,
            ]);


        $path = public_path() . '/img/marca_agua.jpg';
        \Log::debug($path);
        $mpdf->SetDefaultBodyCSS('background', "url('".$path."')");
        $mpdf->SetDefaultBodyCSS('background-image-resize', 6);

        $mpdf->WriteHTML($html_final);

        return $mpdf->Output();
    }
    
}
