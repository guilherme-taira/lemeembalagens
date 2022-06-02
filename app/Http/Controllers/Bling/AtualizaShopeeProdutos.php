<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AtualizaShopeeProdutos extends AtualizaProdutoBling
{
   const TAXA_FIXA = 22;

   public function Calcular(string $sku, float $valor, float $stock, float $peso, float $taxa)
   {
        parent::Calcular($sku, $valor,$stock,$peso,$taxa = self::TAXA_FIXA);
   }
}
