<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = "Orders";


    public static function SumMonth(DateTime $mounth){
        $date = Orders::where('created_at','like','%'.$mounth->format('Y-m').'%')->sum('valor_total');
        return (float) $date;
    }

    public static function CountOrders(DateTime $mounth){
        $data = Orders::where('created_at','like','%'.$mounth->format('Y-m').'%')->count('id');
        return $data;
    }
}
