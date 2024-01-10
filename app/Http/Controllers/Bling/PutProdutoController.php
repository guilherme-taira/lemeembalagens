<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use App\Models\Produtos;
use Illuminate\Http\Request;

interface PutProdutoBling{
    public function resource();
    public function get($resource);
}

class PutProdutoController implements PutProdutoBling
{
    const URL_BASE_PUT_PRODUTO_BLING = "https://bling.com.br/";

    private $sku;
    private $apikey;
    private $precoUnit;
    private $estoque;

    public function __construct($sku,$apikey ,$precoUnit,$estoque)
    {
        $this->sku = $sku;
        $this->apikey = $apikey;
        $this->precoUnit = $precoUnit;
        $this->estoque = $estoque;
    }

    public function resource(){
        return $this->get("Api/v2/produto/{$this->getSku()}/json/");
    }

    public function get($resource){

        // ENDPOINT PARA REQUISIÇÂO
        $endpoint = self::URL_BASE_PUT_PRODUTO_BLING.$resource;
     
        // XML COM DADOS PARA ATUALIZAR 
      
        $xml = "
        <?xml version='1.0' encoding='UTF-8'?>
        <produto>
            <vlr_unit>{$this->getPrecoUnit()}</vlr_unit>
            <estoque>{$this->getEstoque()}</estoque>
        </produto>
        ";

        $posts = array(
            "apikey" => $this->getApikey(),
            "xml" => rawurlencode($xml),
        );


        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $endpoint);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $posts);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($curl_handle);
        $httpCode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        curl_close($curl_handle);

        if($httpCode == "201"){
            print_r($response);
            Produtos::where('sku',$this->getSku())->update(['flag' => '']);
        }else{
            return "Error ao Atualizar o produto! Error -> ". $httpCode;
        }
    }

    /**
     * Get the value of apikey
     */ 
    public function getApikey()
    {
        return $this->apikey;
    }

    /**
     * Get the value of sku
     */ 
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Get the value of precoUnit
     */ 
    public function getPrecoUnit()
    {
        return $this->precoUnit;
    }

    /**
     * Get the value of estoque
     */ 
    public function getEstoque()
    {
        return $this->estoque;
    }
}
