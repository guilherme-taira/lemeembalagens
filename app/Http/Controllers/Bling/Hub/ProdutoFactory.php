<?php

namespace App\Http\Controllers\Bling\Hub;

use App\Http\Controllers\Bling\PutProdutoController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProdutoFactory extends abstractProdutoFactory
{
    public function VerificaPromocao($id, $Valor_promocao, $preco, $stock, \DateTimeInterface $DataInicialPromocao, \DateTimeInterface $DataFinalPromocao, $ativo, $qtdbaixa, $precosite,$nome,$codigo)
    {

        $hoje = new \DateTime();
        if ($this->VerificaPreco($preco) == FALSE) {
            return false;
        } else if ($this->VerificaPreco($preco) == TRUE) {

            if ($DataFinalPromocao->format('Y-m-d') >= $hoje->format('Y-m-d') && $precosite == 0) {
               
                $putProduto = new PutProdutoController($id,env('KEY_BLING'),$Valor_promocao,$stock,$nome,$codigo);
                $putProduto->resource();
                // $AtualizaPrecoEstoqueTray = new AtualizaPromocaoTray($_SESSION['access_token_tray'], $id, $this->VerificaPrecoDiferenteLojaFiscia($Valor_promocao, $precosite), $preco, $this->Dividesaldo($stock, $qtdbaixa), $DataInicialPromocao->format('Y-m-d'), $DataFinalPromocao->format('Y-m-d'), $ativo, $qtdbaixa);
                // return $AtualizaPrecoEstoqueTray->resource();
            } else {
                $putProduto = new PutProdutoController($id,env('KEY_BLING'),$preco,$stock,$nome,$codigo);
                $putProduto->resource();
                // $AtualizaPrecoEstoqueTray = new AtualizaPromocaoTray($_SESSION['access_token_tray'], $id, 0, $this->VerificaPrecoDiferenteLojaFiscia($preco, $precosite), $this->Dividesaldo($stock, $qtdbaixa), $DataInicialPromocao->format('Y-m-d'), $DataFinalPromocao->format('Y-m-d'), $ativo, $qtdbaixa);
                // return $AtualizaPrecoEstoqueTray->resource();
            }
        }
    }

    public function Dividesaldo($saldo, $qtdbaixa)
    {
        if ($saldo <= 1) {
            $saldo = 0;
            return $saldo;
        } else {
            if ($qtdbaixa == 0) {
                $qtdbaixa = 1;
                return ($saldo / $qtdbaixa) / 2;
            } else {
                return ($saldo / $qtdbaixa) / 2;
            }
        }
    }

    public function VerificaPrecoDiferenteLojaFiscia($precoLoja, $precoSite): float
    {
        if (floatval($precoSite <= 0)) {
            return floatval($precoLoja);
        } else {
            return floatval($precoSite);
        }
    }

    public function VerificaAtivo($Ativo)
    {
        return $Ativo;
    }

    public function VerificaPreco($Valor)
    {
        if ($Valor <= 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
