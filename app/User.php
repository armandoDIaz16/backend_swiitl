<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'curp',
         'PRIMER_APELLIDO',
         'SEGUNDO_APELLIDO',
         'FECHA_NACIMIENTO',
         'CURP',
         'ESTADO',
         'TELEFONO_CASA',
         'TELEFONO_MOVIL',
         'CORREO1',
         'CORREO2',
         'CORREO_INSTITUCIONAL',
         //'CONTRASENIA',
         'CALLE',
         'NUMERO_EXTERIOR',
         'NUMERO_INTERIOR',
         'NACIONALIDAD',
         'SEXO',
         'TIPO_SANGUINEO',
         'NSS',
         'NOMBRE_CONTACTO',
         'TELEFONO_CONTACTO',
         'CORREO_CONTACTO',
         'FK_COLONIA',
         'FK_ESTADO_CIVIL',
         'FK_USUARIO_REGISTRO',
         'FECHA_REGISTRO',
         'FK_USUARIO_MODIFICACION',
         'FECHA_MODIFICACION',
         'BORRADO',
         'NUMERO_CONTROL',
         'CLAVE_CARRERA',
         'SEMESTRE'
    ];

    protected $table = 'users';

    public $timestamps = false;


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

        // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getKeyName(){
        return "PK_USUARIO";
    }
}
