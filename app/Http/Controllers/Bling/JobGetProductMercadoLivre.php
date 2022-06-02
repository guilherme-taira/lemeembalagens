<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use App\Models\Produtos;
use Illuminate\Http\Request;

class JobGetProductMercadoLivre implements JobGetBling
{

    const URL_BASE_API_GET_PRODUTOS_BLING_ID_MKTPLACE = "https://bling.com.br/Api/v2/";

    private $apiKey;
    private $codProd;
    private $loja;

    public function __construct($apiKey,$codProd,$loja)
    {
        $this->apiKey = $apiKey;
        $this->codProd = $codProd;
        $this->loja = $loja;
    }

    public function resource()
    {
        return $this->get("produto/{$this->getCodProd()}/json/");
    }

    public function get($resource)
    {

        // ENDPOINT PARA REQUISICAO
        $endpoint = self::URL_BASE_API_GET_PRODUTOS_BLING_ID_MKTPLACE . $resource;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint . '&apikey=' . $this->getApiKey() . '&estoque=S&loja='.$this->getLoja());
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $produtos = json_decode($response,false);       

        foreach ($produtos as $produto) {
            foreach ($produto as $valores) {

               foreach ($valores as $valor) {
                        $sku = isset( $valor->produto->codigo) ? $valor->produto->codigo : "";
                        $id_Marketplace = isset($valor->produto->produtoLoja) ? $valor->produto->produtoLoja->idProdutoLoja : "";
                
                        /**
                        *   ID DO MERCADO LIVRE DENTRO DA FILA DE REQUISIÇÃO 
                        */ 

                        \App\Jobs\JobMercadoLivreGetId::dispatch($sku,$id_Marketplace)->delay(now()->addSeconds('5'));
               }
            }
        }
        
      
    }

    /**
     * Get the value of apiKey
     */ 
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Set the value of apiKey
     *
     * @return  self
     */ 
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Get the value of codProd
     */ 
    public function getCodProd()
    {
        return $this->codProd;
    }

    /**
     * Set the value of codProd
     *
     * @return  self
     */ 
    public function setCodProd($codProd)
    {
        $this->codProd = $codProd;

        return $this;
    }

    /**
     * Get the value of loja
     */ 
    public function getLoja()
    {
        return $this->loja;
    }

    /**
     * Set the value of loja
     *
     * @return  self
     */ 
    public function setLoja($loja)
    {
        $this->loja = $loja;

        return $this;
    }
}
