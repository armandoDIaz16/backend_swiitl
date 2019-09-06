<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\AspirantePasswordMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class AspirantePasswordController extends Controller
{
    public function sendEmail($CORREO1)
    {
        if (!$this->validateEmail($CORREO1)) {
            return $this->failedResponse();
        }
        $this->send($CORREO1);
        return $this->successResponse();
    }
    public function send($CORREO1)
    {
        $token = $this->createToken($CORREO1);
        Mail::to($CORREO1)->send(new AspirantePasswordMail($token));
    }
    public function createToken($CORREO1)
    {
        $oldToken = DB::table('password_resets')->where('CORREO1', $CORREO1)->first();
        if ($oldToken) {
            return $oldToken->token;
        }
        $token = str_random(60);
        $this->saveToken($token, $CORREO1);
        return $token;
    }
    public function saveToken($token, $CORREO1)
    {
        DB::table('password_resets')->insert([
            'CORREO1' => $CORREO1,
            'token' => $token,
            'created_at' => '18-06-12 10:34:09'
        ]);
    }
    public function validateEmail($CORREO1)
    {
        return !!User::where('CORREO1', $CORREO1)->first();
    }
    public function failedResponse()
    {
        return response()->json([
            'error' => 'Email does\'t found on our database'
        ], Response::HTTP_NOT_FOUND);
    }
    public function successResponse()
    {
        return response()->json([
            'data' => 'Reset Email is send successfully, please check your inbox.'
        ], Response::HTTP_OK);
    }
}
            