<?php

namespace App\Http\Controllers\Bling\Hub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class abstractProdutoFactory extends Controller
{
    public abstract function VerificaPromocao($id, $Valor_promocao, $preco, $stock, \DateTimeInterface $DataInicialPromocao, \DateTimeInterface $DataFinalPromocao, $ativo, $qtdbaixa, $precosite);
    public abstract function Dividesaldo($saldo, $qtdbaixa);
    public abstract function VerificaPrecoDiferenteLojaFiscia($precoLoja, $precoSite): float;
    public abstract function VerificaAtivo($saldo);
    public abstract function VerificaPreco($Valor);
}
