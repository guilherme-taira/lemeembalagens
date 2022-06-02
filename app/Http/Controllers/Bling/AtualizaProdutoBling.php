<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class AtualizaProdutoBling{
    private CalculadorPlataformas $CalculadorPlataformas;

    public function __construct(CalculadorPlataformas $CalculadorPlataformas)
    {
        $this->CalculadorPlataformas = $CalculadorPlataformas;
    }

    public function setCalculadorPlataformas(CalculadorPlataformas $CalculadorPlataformas){
        $this->CalculadorPlataformas = $CalculadorPlataformas;
    }

    public function Calcular(string $sku,float $valor, float $stock,float $peso,float $taxa){
        return $this->CalculadorPlataformas->CalculaMarketplace($sku,$valor,$stock,$peso,$taxa);
    }
}

interface CalculadorPlataformas
{
    public function CalculaMarketplace(string $sku,float $valor, float $stock,float $peso,float $taxa);
    public function CalcularEstoque(float $stock): float;
    public function CalcularValor(float $valor, float $taxa): float;
}