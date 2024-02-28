<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class table_produtos_locais extends Model
{
    use HasFactory;

    protected $table = 'table_produtos_locais';

    public static function IfExists($sku){

        $data = table_produtos_locais::where('sku',$sku)->first();
        if($data){
            return 1;
        }
        return 0;
    }

    public static function updatedProduct($data){

        table_produtos_locais::where('sku',$data[0])->
        update([
            'valor' => $data[3],
            'saldo' => $data[7]
        ]);
    }
}
