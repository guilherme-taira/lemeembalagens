<?php

namespace App\Http\Controllers\Bling\Cadastrar;

use App\Http\Controllers\Controller;
use App\Models\Produtos;
use App\Models\table_produtos_locais;
use App\Models\token;
use Illuminate\Http\Request;

class SobeCadastroController extends AbstractCadastroController
{
    const URL_BASE_PRODUTO_BLING = "https://bling.com.br/";

    public function get($resource){

        try {
            // ENDPOINT PARA REQUISIÇÂO
          $endpoint = self::URL_BASE_PRODUTO_BLING.$resource;
     
          // XML COM DADOS PARA ATUALIZAR 

          $prod = [
            "unidade" => "UN",
            'formato' => "S",
            'codigo' => $this->getProduto()->getCodigo(),
            'nome' => $this->getProduto()->getDescricao(),
            'tipo' => $this->getProduto()->getTipo(),
            'pesoLiquido' => $this->getProduto()->getPesoLiq(),
            'pesoBruto' => $this->getProduto()->getPesoLiq(),
            'preco' => $this->getProduto()->getVlrUnit(),
            'dimensoes' => [ 
                "largura"=> 1,
                "altura"=> 1,
                "profundidade"=> 1,
                "unidadeMedida"=> 1
            ],
            "estoque"=> [
                "minimo"=> 1,
                "maximo"=> $this->getProduto()->getEstoque(),
                "localizacao" => "A"
            ],
            "estrutura"=> [
                "tipoEstoque"=> "F",
                "lancamentoEstoque"=> "A",
                "componentes"=> [
                  [
                    "produto"=> [
                      "id"=> $this->getProduto()->getCodigo()
                    ],
                    "quantidade"=> 200
                  ]
                ]
            ],
          ];  

          // GET TOKEN
          $token = token::getToken();
  
          $curl_handle = curl_init();
          curl_setopt($curl_handle, CURLOPT_URL, $endpoint);
          curl_setopt($curl_handle, CURLOPT_POST, 1);
          curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode($prod));
          curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
          curl_setopt($curl_handle, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'Accept: application/json', "Authorization: Bearer $token"]);
          $response = curl_exec($curl_handle);
          $httpCode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
          curl_close($curl_handle);
          echo "<pre>";
          print_r(json_decode($response));
          if($httpCode == "201"){
                table_produtos_locais::where('sku',$this->getProduto()->getCodigo())->update(['id_bling' => json_decode($response)->data->id, 'INTEGRADO' => 'X','PREPARADO' => '']);
          }else{
              return "Error ao Atualizar o produto! Error -> ". $httpCode;
          }

        } catch (\Exception $th) {
            echo $th->getMessage();
        }
          
    }


    public function resource(){
        $this->get('Api/v3/produtos');
    }
}