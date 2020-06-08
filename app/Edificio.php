<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Edificio extends Model {


    protected $fillable = [
        'NOMBRE',
        'PREFIJO',
        'FK_USUARIO_REGISTRO',
        'FK_CAMPUS',
        'FECHA_REGISTRO',
        'FK_USUARIO_MODIFICACION',
        'FECHA_MODIFICACION',
        'BORRADO'
    ];
    protected $table = 'CATR_EDIFICIO';

    /**
     * @var \App\Campus
     */
    protected $with = ['campus'];


    /**
     * @return \App\Campus
     * @description: OBTIENE EL CAMPUS RELATED CON EL EDIFICIO
     *               HasOne ES PARA RELACIONES 1 A 1 EN BASE DE DATOS
     * @author : Armando Díaz
     * @since  : 9/4/2020
     */
    public function campus(){
        return $this->belongsTo('App\Campus',
            'FK_CAMPUS',
            'PK_CAMPUS')->where('BORRADO', 0);
    }
}
