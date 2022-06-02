<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use App\Models\Produtos;
use Illuminate\Http\Request;

interface SecundarioProduct
{
    public function UpdateValoresSecundario($sku, $saldo, $QTDBAIXA, $valor);
    public function UpdateValoresPrimario($sku, $saldo, $QTDBAIXA, $valor);
    // public function SelectPrimario($sku);
    public function CalculaSaldo($saldo, $QTDBAIXA);
    public function CalculaValor($valor, $QTDBAIXA);
}

class UpdateSecoundProductController implements SecundarioProduct
{
    public function UpdateValoresSecundario($sku, $saldo, $QTDBAIXA, $valor)
    {
        $Secundarios = Produtos::where('secundario', $sku)->get();
        foreach ($Secundarios as $secundario) {
            Produtos::where('sku', $secundario->sku)->update(['saldo' => floatval($this->CalculaSaldo($saldo, $secundario->QTDBAIXA)), 'valor' => $this->CalculaValor($valor, $secundario->QTDBAIXA)]);
        }
    }

    public function UpdateValoresPrimario($sku, $saldo, $QTDBAIXA, $valor)
    {

        $Secundarios = Produtos::where('sku', $sku)->get();
        foreach ($Secundarios as $secundario) {
            Produtos::where('sku', $secundario->sku)->update(['saldo' => floatval($saldo), 'valor' => $valor]);
        }
        // verifica se há secundario
        $secound = Produtos::where('secundario', $sku)->get();
        if ($secound->count() > 0) {
            $this->UpdateValoresSecundario($sku, $saldo, $QTDBAIXA, $valor);
        }
    }

    public function CalculaSaldo($saldo, $QTDBAIXA)
    {
        $BAIXADO = ($QTDBAIXA == 0) ? 1 : $QTDBAIXA;
        $QUANTIDADE = ($saldo == 0) ? 1 : $saldo;
        return number_format(($QUANTIDADE / $BAIXADO), 2);
    }

    public function CalculaValor($valor, $QTDBAIXA)
    {
        return number_format(($valor * $QTDBAIXA), 2);
    }
}
