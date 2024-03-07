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
      
        $lojas = multiloja::get();
        foreach ($lojas as $loja) {
  
            $data = [
                'idLoja' => $loja->idmultiloja,
            ];
    
        $token = token::getToken();
        //curl_setopt($ch, CURLOPT_URL, $endpoint . '&apikey=' . $this->getApiKey() . '&estoque=S&loja=203664307');
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'Accept: application/json', "Authorization: Bearer $token"]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));  
        $response = curl_exec($ch);
        curl_close($ch);
        $produtos = json_decode($response, false);
        // echo "<pre>";
        // print_r($produtos);
        // foreach ($produtos as $produto) {
        //     foreach ($produto as $valores) {
        //         foreach ($valores as $valor) {
        //              $id_Marketplace = isset($valor->produto->produtoLoja->idProdutoLoja) ? $valor->produto->produtoLoja->idProdutoLoja : "";
        //              $data = Produtos::max('id');
                   
        //             $verifica = Produtos::where('sku', $valor->produto->codigo)->first();
        //             if (!$verifica) {
        //                 // print_r($valores);
        //                 $salvar = new Produtos;
        //                 $salvar->nome = $valor->produto->descricao;
        //                 $salvar->sku = empty($valor->produto->codigo) ? $data : $valor->produto->codigo;
        //                 $salvar->saldo = floatval($valor->produto->estoqueAtual);
        //                 $salvar->QTDBAIXA = $valor->produto->itensPorCaixa;
        //                 $salvar->valor = $this->converterValor(number_format($valor->produto->preco, 2));
        //                 $salvar->ean = uniqid();
        //                 $salvar->secundario = uniqid();
        //                 $salvar->valorPromocional = 0;
        //                 $salvar->dataInicial = '1111-11-11';
        //                 $salvar->dataFinal = '1111-11-11';
        //                 $salvar->flag = '';
        //                 $salvar->desconto = 0;
        //                 $salvar->ativo = $valor->produto->situacao;
        //                 $salvar->save();
        //             }else{
        //                 $id = (string) $loja->name;
        //                 if($id_Marketplace != $loja->idmultiloja){
        //                     table_produtos_locais::where('sku',$valor->produto->codigo)->update([$id => $id_Marketplace,'peso' => $valor->produto->pesoLiq, 'altura' => $valor->produto->alturaProduto, 'largura' => $valor->produto->larguraProduto,'comprimento' => $valor->produto->profundidadeProduto]);
        //                 }
        //             }
        //         }
            // }
        // }
    }
          # code...
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
