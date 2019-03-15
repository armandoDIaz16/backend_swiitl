<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Generar_Preficha extends Model
{
    protected $connection = 'sqlsrv';

    public function get_generar_preficha(){
        $pdo = DB::connection('sqlsrv')->select('EXEC GENERAR_PREFICHA');
        return $pdo;
    }
}
