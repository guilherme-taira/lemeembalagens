<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use App\Models\Produtos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

define('URL_BASE_API_GET_PRODUTOS_BLING', "https://bling.com.br/Api/v2/");

class GetProdutosApiBlingController extends Controller
{

    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function resource()
    {
        return $this->get('produtos/page=1/json/');
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
        //curl_setopt($ch, CURLOPT_URL, $endpoint . '&apikey=' . $this->getApiKey() . '&estoque=S&loja=203664307');
        curl_setopt($ch, CURLOPT_URL, $endpoint . '&apikey=' . $this->getApiKey() . '&estoque=S'.'&loja=204761707');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $produtos = json_decode($response, false);

        foreach ($produtos as $produto) {
            foreach ($produto as $valores) {
                foreach ($valores as $valor) {
                    $data = Produtos::max('id');
                    $id_Marketplace = isset($valor->produto->produtoLoja) ? $valor->produto->produtoLoja : "";
                    $verifica = Produtos::where('sku', $valor->produto->codigo)->first();
                    if (!$verifica) {
                        // print_r($valores);
                        $salvar = new Produtos;
                        $salvar->nome = $valor->produto->descricao;
                        $salvar->sku = empty($valor->produto->codigo) ? $data : $valor->produto->codigo;
                        $salvar->saldo = floatval($valor->produto->estoqueAtual);
                        $salvar->QTDBAIXA = $valor->produto->itensPorCaixa;
                        $salvar->valor = $this->converterValor(number_format($valor->produto->preco, 2));
                        $salvar->ean = uniqid();
                        $salvar->secundario = uniqid();
                        $salvar->valorPromocional = 0;
                        $salvar->dataInicial = '1111-11-11';
                        $salvar->dataFinal = '1111-11-11';
                        $salvar->flag = '';
                        $salvar->desconto = 0;
                        $salvar->ativo = $valor->produto->situacao;
                        $salvar->save();
                    }
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
}
