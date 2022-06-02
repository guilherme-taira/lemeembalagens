<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use App\Models\Produtos;
use Illuminate\Http\Request;
use Whoops\Handler\JsonResponseHandler;

class ajaxCargaBlingController extends Controller
{
    public function Carga(Request $request){
        $dados = Produtos::where('id',$request->sku)->first();
        $Produto = new PutProdutoController($dados->sku,'e9cbe27923c0c4b22d92b71cd59662df300da8c89b11775d37113ed469ec20ada8cf2153',$dados->valor,$dados->saldo);
        $result = $Produto->resource();
        return response()->json(["dados" => $result]);
    }
}
