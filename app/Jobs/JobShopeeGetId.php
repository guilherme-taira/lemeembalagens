<?php

namespace App\Jobs;

use App\Models\Produtos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class JobShopeeGetId implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $sku;
    private $id_shopee;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sku, $id_shopee)
    {
        $this->sku = $sku;
        $this->id_shopee = $id_shopee;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Produtos::where('sku',$this->getSku())->update(['id_shopee' => $this->getId_shopee()]);
    }

    /**
     * Get the value of id_shopee
     */ 
    public function getId_shopee()
    {
        return $this->id_shopee;
    }

    /**
     * Get the value of sku
     */ 
    public function getSku()
    {
        return $this->sku;
    }
}
