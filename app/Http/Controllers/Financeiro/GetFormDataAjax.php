<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\items;
use App\Models\Orders;
use Illuminate\Http\Request;

class GetFormDataAjax extends Controller
{
    public function getData(Request $request){

        $valor = json_encode(Orders::where('cliente','like','%'.$this->getName($request).'%')->get());
        return response()->json(["dados" => $valor],200);
    }
    
    public function getProducts(Request $request){
        $valor = [];
        $index = 0;
        $products = items::where('n_order',$request->n_order)->get();
   
        
        return response()->json(["products" => json_encode($products)],200);
    }

    public function getName(Request $request){
        if(isset($request->name)){
            return $request->name;
        }else{
            return "";
        }
    }
}
