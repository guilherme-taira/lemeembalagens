<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AtualizaBlingProdutos extends AtualizaProdutoBling
{
  
    public function Calcular(string $sku, float $valor, float $stock, float $peso, float $taxa)
    {
        parent::Calcular($sku,$valor,$stock,$peso,$taxa);   
    }
}
