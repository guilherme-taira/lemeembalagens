<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use App\Models\Produtos;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;


interface JobGetBling
{
    public function resource();
    public function get($resource);
}

abstract class JobGetIdsMarketplace
{
    abstract function MarketplacesJobs();
    abstract function MarketplacesJobsMercadolivre(string $sku);
    abstract function MarketplacesJobsShopee(string $sku);
    abstract function MarketplacesJobsTray(string $sku);
}

class JobGetProductController extends JobGetIdsMarketplace
{

    public function MarketplacesJobs()
    {
        $produtos = Produtos::all()->where('id_mercadoLivre', '=', '')->where('id_shopee','=','')->where('tray','=','');
        foreach ($produtos as $produto) {
            $this->MarketplacesJobsMercadolivre($produto->sku);
                $this->MarketplacesJobsShopee($produto->sku);
                    $this->MarketplacesJobsTray($produto->sku);
        }
    }

    public function MarketplacesJobsMercadolivre($sku)
    {
        $JobGetProductMercadoLivre = new JobGetProductMercadoLivre('a0e92e1b13cad53953fa6b425bc6cb36bcf51d327ec8ca3c9a0c20d271edb3585cc96277', $sku, '203874743');
        $JobGetProductMercadoLivre->resource();
    }

    public function MarketplacesJobsShopee($sku)
    {
        $JobGetProductMercadoLivre = new JobGetProductShopee('a0e92e1b13cad53953fa6b425bc6cb36bcf51d327ec8ca3c9a0c20d271edb3585cc96277', $sku, '203664307');
        $JobGetProductMercadoLivre->resource();
    }

    public function MarketplacesJobsTray($sku)
    {
        $JobGetProductMercadoLivre = new JobGetProductTray('a0e92e1b13cad53953fa6b425bc6cb36bcf51d327ec8ca3c9a0c20d271edb3585cc96277', $sku, '203436048');
        $JobGetProductMercadoLivre->resource();
    }
}
