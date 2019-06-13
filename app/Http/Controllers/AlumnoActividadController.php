<?php

namespace App\Http\Controllers;

use App\alumno_actividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Mail\RegistroActividadMail;

use DB;
use QrCode;
use Mail;

class AlumnoActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alumno_actividad = alumno_actividad::all();
        QrCode::size(500)->generate('hola');

        $response = Response::json($alumno_actividad);
        return $response;



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
        $alumno_actividad = new alumno_actividad();
        $alumno_actividad->FK_ACTIVIDAD = $request->FK_ACTIVIDAD;
        $alumno_actividad->FK_ALUMNO = $request->FK_ALUMNO;
        $alumno_actividad->save();
        //echo json_encode($alumno_actividad);
    
        //obtener el id de la actividad que se acaba de registrar
        $actividad = alumno_actividad::select('PK_ALUMNO_ACTIVIDAD')
                            ->where('FK_ACTIVIDAD','=', $request->FK_ACTIVIDAD)
                            ->where('FK_ALUMNO','=', $request->FK_ALUMNO)
                            ->get()->first();
        
        //Obtener el email del usuario que se registro
        $correo = DB::table('users')
                    ->select('email','name')
                    ->where('PK_USUARIO','=', $request->FK_ALUMNO)
                    ->get()->first();
        
        //obtener los datos de la actividad
        $datos_act = DB::table('ACTIVIDADES')
                     ->select('NOMBRE','FECHA','LUGAR','HORA')
                     ->where('PK_ACTIVIDAD','=', $request->FK_ACTIVIDAD)
                     ->get()->first();
 
        QrCode::format('png')->size(500)->generate($actividad->PK_ALUMNO_ACTIVIDAD, public_path('creditos-complementarios/codigos-qr-a-c/qrcode-f-'.$actividad->PK_ALUMNO_ACTIVIDAD.'.png'));

        Mail::to($correo->email, $correo->name)
            ->send(new RegistroActividadMail($actividad->PK_ALUMNO_ACTIVIDAD,$correo->name, $datos_act->NOMBRE, $datos_act->FECHA, $datos_act->LUGAR, $datos_act->HORA));

        //echo "correo enviado";
  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\alumno_actividad  $alumno_actividad
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /* mostrar la cantidad de alumnos registrados por actividad */
        $registrados = alumno_actividad::get()->where('FK_ACTIVIDAD','=',$id)->count();
        echo json_encode($registrados);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\alumno_actividad  $alumno_actividad
     * @return \Illuminate\Http\Response
     */
    public function edit(alumno_actividad $alumno_actividad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\alumno_actividad  $alumno_actividad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, alumno_actividad $alumno_actividad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\alumno_actividad  $alumno_actividad
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $alumno_actividad = alumno_actividad::find($id);
        $alumno_actividad->delete();
    }

    public function ctlAlumnoActividad ($FK_ACTIVIDAD, $FK_ALUMNO) {
        //obtener el id de la actividad que se acaba de registrar
        $actividad = alumno_actividad::select('PK_ALUMNO_ACTIVIDAD')
        ->where('FK_ACTIVIDAD', '=', $FK_ACTIVIDAD)
        ->where('FK_ALUMNO','=', $FK_ALUMNO)
        ->get()->first();

        $response = Response::json($actividad);
       return $response;
   }
}

