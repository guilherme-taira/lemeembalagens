<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use App\Models\multiloja;
use App\Models\Produtos;
use App\Models\table_produtos_locais;
use App\Models\token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

define('URL_BASE_API_GET_PRODUTOS_BLING', "https://bling.com.br/Api/v3/");

class GetProdutosApiBlingController extends Controller
{

    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function resource()
    {
        return $this->get('produtos');
    }

   
    function converterValor($valor) {
        // Remover a vírgula
        $valorSemVirgula = str_replace(',', '', $valor);

        // Converter para float
        $valorConvertido = floatval($valorSemVirgula);

        return $valorConvertido;
    }

    public function get($resource)
    {

        // ENDPOINT PARA REQUISICAO
        $endpoint = URL_BASE_API_GET_PRODUTOS_BLING . $resource;
        $ch = curl_init();
          
        $token = token::getToken();
        //curl_setopt($ch, CURLOPT_URL, $endpoint . '&apikey=' . $this->getApiKey() . '&estoque=S&loja=203664307');
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'Accept: application/json', "Authorization: Bearer $token"]);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));  
        $response = curl_exec($ch);
        curl_close($ch);
        $produtos = json_decode($response, false);
        foreach ($produtos->data as $produto) {
            $this->getInfoDetail($token,$produto->id,$endpoint);
        }
    }


    public function getInfoDetail($token,$id,$endpoint){
        // ENDPOINT PARA REQUISICAO
        $endpoint .= '/'.$id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'Accept: application/json', "Authorization: Bearer $token"]);
        $response = curl_exec($ch);
        curl_close($ch);
        $produtos = json_decode($response, false);
        foreach ($produtos as $produto) {
            table_produtos_locais::where('sku',$produto->codigo)->update(['peso' => $produto->pesoLiquido, 'altura' => $produto->dimensoes->altura, 'largura' => $produto->dimensoes->largura,'comprimento' => $produto->dimensoes->profundidade]);
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
}
