<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImplementadorShopee  implements CalculadorPlataformas
{
    public function CalculaMarketplace(string $sku, float $valor, float $stock, float $peso, float $taxa)
    {
        $BlingPut = new PutProdutoController($sku,'a0e92e1b13cad53953fa6b425bc6cb36bcf51d327ec8ca3c9a0c20d271edb3585cc96277',$this->CalcularValor($valor,$taxa),$this->CalcularEstoque($stock));
        $BlingPut->resource();
    }

    public function CalcularEstoque(float $stock): float
    {
        $total = floatval($stock / 2);
        return $total;
    }

    public function CalcularValor(float $valor, float $taxa):float
    {   
        $taxaFixa = $taxa / 100;
        $total = (($valor * $taxaFixa) + $valor);
        return $total; 
    }
}
