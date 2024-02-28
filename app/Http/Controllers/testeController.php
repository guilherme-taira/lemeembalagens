<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Bling\GetProdutosApiBlingController;
use App\Http\Controllers\Bling\Nfe\NfeController;
use Illuminate\Http\Request;

class testeController extends Controller
{
    public function teste()
    {
        echo "<h1> NOTA FISCAL </h1>";
        // $nf = new NfeController('S','1','EMBALAGENS','232313','LOJA EMBA','F','46857167877','1','Siqueira Campos','70','Casa','São Manoel','13616450','Leme','SP','19999920256','gui_ssx@hotmail.com','SEDEX','784512123780','1','BALA DE COCO',1,29,29.90,'P',1);
        // $nf->resource();
        $produto = new GetProdutosApiBlingController('1aeeb29ae86d4f320c8fbce3a893e23b187121e46d88590d3dcf37f53ff771c23b0ce90a');
        print_r($produto->resource());
    }
}
