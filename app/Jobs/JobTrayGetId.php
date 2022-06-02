<?php

namespace App\Jobs;

use App\Models\Produtos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class JobTrayGetId implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $sku;
    private $id_tray;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sku, $id_tray)
    {
        $this->sku = $sku;
        $this->id_tray = $id_tray;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Produtos::where('sku',$this->getSku())->update(['tray' => $this->getId_tray()]);
    }

    /**
     * Get the value of id_shopee
     */ 
 
    /**
     * Get the value of sku
     */ 
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Get the value of id_tray
     */ 
    public function getId_tray()
    {
        return $this->id_tray;
    }
}
