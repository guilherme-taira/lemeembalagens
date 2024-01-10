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
        $Produto = new PutProdutoController($dados->sku,'1aeeb29ae86d4f320c8fbce3a893e23b187121e46d88590d3dcf37f53ff771c23b0ce90a',$dados->valor,$dados->saldo);
        $result = $Produto->resource();
        return response()->json(["dados" => $result]);
    }
}
