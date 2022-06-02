<?php

namespace App\Jobs;

use App\Http\Controllers\Bling\PutProdutoController;
use App\Models\jobs;
use App\Models\Produtos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class atualizaProduto implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $sku;
    private $valor;
    private $saldo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $sku,float $valor,float $saldo)
    {
        $this->sku = $sku;
        $this->valor = $valor;
        $this->saldo = $saldo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
          $atualiza = new PutProdutoController($this->getSku(),'e9cbe27923c0c4b22d92b71cd59662df300da8c89b11775d37113ed469ec20ada8cf2153',$this->getValor(),$this->getSaldo());
            $atualiza->resource();
    }

    /**
     * Get the value of sku
     */ 
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Get the value of valor
     */ 
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Get the value of saldo
     */ 
    public function getSaldo()
    {
        return $this->saldo;
    }
}
