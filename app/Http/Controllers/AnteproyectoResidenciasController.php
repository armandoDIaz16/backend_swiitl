<?php

namespace App\Http\Controllers;

use App\CreditosSiia;
use Illuminate\Http\Request;
use App\CargaArchivo;
use App\AnteproyectoResidencias;
use App\PeriodoResidencia;
use Illuminate\Support\Facades\DB;
use function Psy\debug;

class AnteproyectoResidenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vistaante = AnteproyectoResidencias::all();
        return $vistaante;
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
        $fecha = new PeriodoResidencia();
        $dia = date('Y-m-d');
        $alumno = DB::select('SELECT ID_PADRE FROM CATR_ALUMNO WHERE ID_PADRE = :id',['id'=>$request->Autor]);
        $x = NULL;

        if($alumno != NULL){
            $x = $request->Autor;
            try{
                $anteproyectos = AnteproyectoResidencias::where('ALUMNO',$x)->first();
                $anteproyectos->ALUMNO = NULL;
                $anteproyectos->save();
            }catch(\Exception $exception){

            }
            $diai = $fecha->FIniA($x,1);
            $diaf = $fecha->FFinA($x,1);
            if($diai<=$dia && $dia<=$diaf){
                $anteproyecto->NOMBRE = $request->Nombre;
                $anteproyecto->PDF = $request->pdf;
                $anteproyecto->ALUMNO = $x;
                $anteproyecto->ESTATUS = '1';
                $anteproyecto->AREA_ACADEMICA = $request->AreaAcademica;
                $anteproyecto->AUTOR = $request->Autor;
                $anteproyecto->EMPRESA = $request->Empresa;
                $anteproyecto->COMENTARIO = $request->Comentario;
                $periodo = new CreditosSiia();
                $anteproyecto->PERIODO = $periodo->periodo();
                $anteproyecto->save();
            }
        }else{
            $anteproyecto->NOMBRE = $request->Nombre;
            $anteproyecto->PDF = $request->pdf;
            $anteproyecto->ALUMNO = $x;
            $anteproyecto->ESTATUS = '1';
            $anteproyecto->AREA_ACADEMICA = $request->AreaAcademica;
            $anteproyecto->AUTOR = $request->Autor;
            $anteproyecto->EMPRESA = $request->Empresa;
            $anteproyecto->TIPO_ESPECIALIDAD = $request->Comentario;
            $periodo = new CreditosSiia();
            $anteproyecto->PERIODO = $periodo->periodo();
            $anteproyecto->save();
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return AnteproyectoResidencias::where('ID_ANTEPROYECTO',$id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return AnteproyectoResidencias::where('ID_ANTEPROYECTO',$id)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ID_ANTEPROYECTO)
    {
        $anteproyecto = AnteproyectoResidencias::where('ID_ANTEPROYECTO',$ID_ANTEPROYECTO)->first();
        $fecha = new PeriodoResidencia();
        $dia = date('Y-m-d');

        //$carga = new CargaArchivo();

            if($request->Nombre) {
                $anteproyecto->NOMBRE = $request->Nombre;
            }
            if($request->pdf){
                //$ruta = $carga->savefile($request);
                //$anteproyecto->pdf = $ruta;
            }
            if($request->Alumno){
                $diai = $fecha->FIniA($request->Alumno,1);
                $diaf = $fecha->FFinA($request->Alumno,1);
                if($diai<=$dia && $dia<=$diaf) {
                    $x = $request->Alumno;
                    $etse = AnteproyectoResidencias::where('ALUMNO', $x)->first();
                    if ($anteproyecto->Alumno != 'NULL') {
                        if ($etse == NULL) {
                            $anteproyecto->ALUMNO = $x;
                            //return $f = json_encode('ok');
                        } else ;//return $i = json_encode('Un alumno no puede tener más de un proyecto.');
                    } else ;//return  $h = json_encode('Proyecto ya esta asignado a un alumno.');
                    //$anteproyecto->Alumno = $request->Alumno;
                }
            }
            if($request->Estatus){
                $anteproyecto->ESTATUS = $request->Estatus;
            }
            if($request->AreaAcademica){
                $anteproyecto->AREA_ACADEMICA = $request->AreaAcademica;
            }
            if($request->Autor){
                $anteproyecto->AUTOR = $request->Autor;
            }
            if($request->Empresa){
                $anteproyecto->EMPRESA = $request->Empresa;
            }
            if($request->Comentario){
                $anteproyecto->COMENTARIO = $request->Comentario;
            }
            if($request->Cancelar){
                $diai = $fecha->FIniA($anteproyecto->ALUMNO,1);
                $diaf = $fecha->FFinA($anteproyecto->ALUMNO,1);
                if($diai<=$dia && $dia<=$diaf) {
                    $anteproyecto->ALUMNO = NULL;
                }
            }
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

    public function ind1($id){
        $area = DB::select('SELECT FK_AREA_ACADEMICA FROM CATR_CARRERA
                  JOIN CATR_ALUMNO ON CATR_CARRERA.CLAVE = CATR_ALUMNO.CLAVE_CARRERA
                  WHERE CATR_ALUMNO.ID_PADRE = :id',['id'=>$id]);
        $area1 = json_decode(json_encode($area),true);
        $area2 = array_pop($area1);
        $area3 = array_pop($area2);
        $vistaante = DB::select('SELECT * FROM CAT_ANTEPROYECTO_RESIDENCIA WHERE AREA_ACADEMICA = :area AND ALUMNO IS NULL',['area'=>$area3]);
        return $vistaante;
    }

    public function ind2($id){
        $area = DB::select('SELECT ID_AREA_ACADEMICA FROM CATR_DOCENTE WHERE CATR_DOCENTE.ID_PADRE = :id',['id'=>$id]);
        $area1 = json_decode(json_encode($area),true);
        $area2 = array_pop($area1);
        $area3 = array_pop($area2);
        $vistaante = DB::select('SELECT * 
                                        FROM CAT_ANTEPROYECTO_RESIDENCIA 
                                        JOIN users ON CAT_ANTEPROYECTO_RESIDENCIA.ALUMNO = users.PK_USUARIO
                                        WHERE AREA_ACADEMICA = :area AND ALUMNO <> :id',['area'=>$area3,'id'=>'NULL']);
        return $vistaante;
    }

    public function alumno($id)
    {
        return AnteproyectoResidencias::where('ALUMNO',$id)->get();
    }

    public function proyecto(Request $request){
        $ALUMNO = $request->id;
        $anteproyecto = AnteproyectoResidencias::where('ALUMNO',$ALUMNO)->first();
        $carga = new CargaArchivo();
        $ruta = $carga->savefile($request);
        $anteproyecto->PDF = $ruta;
        try{
        $anteproyecto->save();
        return json_encode('Guardado con exito!');}
        catch(\Exception $exception){
            return json_encode('Error al subir archivo');
        }
    }
}
