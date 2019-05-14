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
    public function sendEmail($email)
    {
        if (!$this->validateEmail($email)) {
            return $this->failedResponse();
        }
        $this->send($email);
        return $this->successResponse();
    }
    public function send($email)
    {
        $token = $this->createToken($email);
        Mail::to($email)->send(new AspirantePasswordMail($token));
    }
    public function createToken($email)
    {
        $oldToken = DB::table('password_resets')->where('email', $email)->first();
        if ($oldToken) {
            return $oldToken->token;
        }
        $token = str_random(60);
        $this->saveToken($token, $email);
        return $token;
    }
    public function saveToken($token, $email)
    {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => '18-06-12 10:34:09'
        ]);
    }
    public function validateEmail($email)
    {
        return !!User::where('email', $email)->first();
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
            