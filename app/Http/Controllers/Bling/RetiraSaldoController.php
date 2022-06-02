<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use App\Models\Produtos;
use Illuminate\Http\Request;

interface RetiraSaldo
{
    public function retira(string $id, float $saldo, float $quantidade);
    public function Produto(string $id, float $quantidade);
    public function InformeSaldoBaixo($id);
}

class RetiraSaldoController implements RetiraSaldo
{
    public function retira($id, $saldo, $quantidade)
    {
        $total = $saldo - $quantidade;
        if ($total <= 5) {
            $this->InformeSaldoBaixo($id);
        }

        return $total;
    }

    public function Produto(string $id, float $quantidade)
    {
        $dados = Produtos::where('sku', $id)->get();
        foreach ($dados as $dado) {
            $saldo = $this->retira($id, $dado->saldo, $quantidade);
   
            $UpdateSecoundProductController = new UpdateSecoundProductController();
            $UpdateSecoundProductController->UpdateValoresPrimario($id, $saldo, $dado->QTDBAIXA, $dado->valor);
        }
    }

    public function InformeSaldoBaixo($id)
    {
        Produtos::where('sku', $id)->update(['BaixoSaldo' => 'X']);
    }
}
