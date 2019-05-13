<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipo extends Model
{
    protected $table = 'TIPOS';

    protected $primaryKey = 'PK_TIPO';

    public $timestamps = false;
}
