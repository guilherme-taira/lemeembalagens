<?php

namespace App\Jobs;

use App\Models\Produtos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class JobMercadoLivreGetId implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $sku;
    private $id_mercadolivre;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sku, $id_mercadolivre)
    {
        $this->sku = $sku;
        $this->id_mercadolivre = $id_mercadolivre;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Produtos::where('sku',$this->getSku())->update(['id_mercadoLivre' => $this->getId_mercadolivre()]);
    }

    /**
     * Get the value of sku
     */ 
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Get the value of id_mercadolivre
     */ 
    public function getId_mercadolivre()
    {
        return $this->id_mercadolivre;
    }
}
