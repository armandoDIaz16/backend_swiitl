<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CargaArchivo extends Model
{
    function saveFile(Request $request){
        $File = $request->file('myfile');
        $sub_path = 'files';
        $real_name = $File->getClientOriginalName();
        $destination_path = public_path($sub_path);
        $File->move($destination_path,$real_name);
        $final_path = $sub_path."/".$real_name;

        return $final_path;
    }
}
