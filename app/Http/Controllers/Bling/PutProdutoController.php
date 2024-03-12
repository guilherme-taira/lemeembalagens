<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use App\Models\multiloja;
use App\Models\Produtos;
use App\Models\table_produtos_locais;
use App\Models\token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

interface PutProdutoBling
{
    public function resource();
    public function get($resource);
}

class PutProdutoController implements PutProdutoBling
{

    const DIVISOR = 6000;
    const URL_BASE_PUT_PRODUTO_BLING = "https://www.bling.com.br/";

    private $sku;
    private $apikey;
    private $precoUnit;
    private $estoque;
    private $nome;
    private $codigo;

    public function __construct($sku, $apikey, $precoUnit, $estoque,$nome,$codigo)
    {
        $this->sku = $sku;
        $this->apikey = $apikey;
        $this->precoUnit = $precoUnit;
        $this->estoque = $estoque;
        $this->nome = $nome;
        $this->codigo = $codigo;
    }

    public function resource()
    {
        return $this->get("Api/v3/produtos/{$this->getSku()}");
    }

    public function get($resource)
    {
        // ENDPOINT PARA REQUISIÇÂO
        $endpoint = self::URL_BASE_PUT_PRODUTO_BLING . $resource;
          // GET TOKEN
          $token = token::getToken();
    
          $curl_handle = curl_init();
          curl_setopt($curl_handle, CURLOPT_URL, $endpoint);
          curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
          curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, 'PUT');
          curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $this->toJson());
          curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
          curl_setopt($curl_handle, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'Accept: application/json', "Authorization: Bearer $token"]);
          $response = curl_exec($curl_handle);
          $httpCode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
          curl_close($curl_handle);

        if ($httpCode == "200") {
            $EstoqueController = new EstoqueController($this->getSku(),$this->getEstoque());
            $EstoqueController->resource();
            $this->updateMultiLoja($endpoint,$token);
            // table_produtos_locais::where('id_bling', $this->getSku())->update(['flag' => '']);
        } else {
            return "Error ao Atualizar o produto! Error -> " . $httpCode;
        }
    }

    public function toJson(){

        $data = [
            "preco"=> $this->getPrecoUnit(),
            "tipo"=> "P",
            "formato"=> "S",
            "nome"=> $this->getNome(),
            "unidade" => "UN",
            "codigo" => $this->getCodigo()
        ];

        return json_encode($data);
    }
    
    public function updateMultiLoja($endpoint,$token)
    {
    
        $lojas = multiloja::get();
        // VERIFICA LOJA
        $produtoLocal = table_produtos_locais::where('id_bling', $this->getSku())->first();

        foreach ($lojas as $key => $value) {

            if ($produtoLocal[$value->name]) {

            try {
                
                // IMPLEMENTAR O ID DO MULTILOJA GRAVADO.
                $endpoint = "https://www.bling.com.br/Api/v3/produtos/lojas/{$this->getLocalLojaID($value->name,$lojas,$produtoLocal)}";

                echo $endpoint;
                echo "<hr>";
                // IMPLEMENTAR O CODIGO PARA PUXAR OS DADOS DE ACORDO COM O MKTs
                $prod = [
                    "codigo" => $this->getLocalLoja($value->name,$lojas,$produtoLocal), 
                    "produto" => [
                          "id" => $produtoLocal['id_bling'] 
                       ], 
                    "loja" => [
                             "id" => $value->idmultiloja 
                          ], 
                    "preco" => $this->getLocal($value->name) 
                 ]; 
                // echo "<pre>";
                //  print_r($prod);

                    $curl_handle = curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL, $endpoint);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, 'PUT');
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode($prod));
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($curl_handle, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'Accept: application/json', "Authorization: Bearer $token"]);
                    $response = curl_exec($curl_handle);
                    $httpCode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
                    curl_close($curl_handle);
                    $res = json_decode($response);
                    print_r($res);
                
              
            } catch (\Exception $th) {
                echo $th->getMessage();
            }
         }
        }
    }


    public function getLocalLoja($id_loja,$lojas,$produtoLocal){

        foreach ($lojas as $loja) {
            if($loja->name == $id_loja){
                switch ($loja->name) {
                    case 'tray':
                        return $produtoLocal['tray'];

                    case 'id_shopee':
                        return $produtoLocal['id_shopee'];
                        
                        case 'id_mercadolivre':
                            return $produtoLocal['id_mercadolivre'];
                }
            }
        }
        
    }


    public function getLocalLojaID($id_loja,$lojas,$produtoLocal){

        foreach ($lojas as $loja) {
            if($loja->name == $id_loja){
                switch ($loja->name) {
                    case 'tray':
                        return $produtoLocal['id_tray_loja'];

                    case 'id_shopee':
                        return $produtoLocal['id_shopee_loja'];
                        
                        case 'id_mercadolivre':
                            return $produtoLocal['id_mercadolivre_loja'];
                }
            }
        }
        
    }

    public function getLocal($value)
    {
        switch ($value) {
            case 'id_mercadoLivre':
                return $this->getMercadoLivreValue();
            case 'id_shopee':
                return $this->getShopeeValue();
            case 'tray':
                return $this->getSiteValue();
        }
    }

    public function getSiteValue()
    {
        return $this->getPrecoUnit();
    }

    public function getShopeeValue()
    {
        $preco = ($this->getPrecoUnit() + 3) / 0.80;
        return $preco;
    }

    public function getMercadoLivreValue()
    {

        $valor_produto = ($this->getPrecoUnit() + ($this->getPrecoUnit() * 0.19)) + $this->Frete(floatval($this->CalculoCubico($this->getSku())));

        if ($valor_produto < 79) {
            $valor_produto = ($this->getPrecoUnit() + 6) + ($this->getPrecoUnit() * 0.19);
            return $valor_produto;
        } else {
            return $valor_produto;
        }
    }

    function converterValor($valor)
    {
        // Remover a vírgula
        $valorSemVirgula = str_replace(',', '', $valor);

        // Converter para float
        $valorConvertido = floatval($valorSemVirgula);

        return $valorConvertido;
    }
    public function Frete(string $peso)
    {
        if ($peso <= 300) {
            return number_format(18.95, 2);
        } else if ($peso >= 300 && $peso <= 500) {
            return 19.45;
        } else if ($peso >= 500 && $peso <= 1000) {
            return 21.45;
        } else if ($peso >= 1000 && $peso <= 2000) {
            return 22.45;
        } else if ($peso >= 2000 && $peso <= 3000) {
            return 22.95;
        } else if ($peso >= 3000 && $peso <= 4000) {
            return 23.45;
        } else if ($peso >= 4000 && $peso <= 5000) {
            return 23.95;
        } else if ($peso >= 5000 && $peso <= 9000) {
            return 40.95;
        } else if ($peso >= 9000 && $peso <= 13000) {
            return 63.95;
        } else if ($peso >= 13000 && $peso <= 17000) {
            return 71.45;
        } else if ($peso >= 17000 && $peso <= 23000) {
            return 83.45;
        } else if ($peso >= 23000 && $peso <= 30000) {
            return 95.95;
        } else if ($peso >= 30000 && $peso <= 40000) {
            return 106.45;
        } else if ($peso >= 40000 && $peso <= 50000) {
            return 113.45;
        } else if ($peso >= 50000 && $peso <= 60000) {
            return 121.45;
        } else if ($peso >= 60000 && $peso <= 70000) {
            return 137.45;
        } else if ($peso >= 70000 && $peso <= 80000) {
            return 152.45;
        } else if ($peso >= 80000 && $peso <= 90000) {
            return 169.95;
        }
    }

    public function FreteSpecial(string $peso)
    {
        if ($peso <= 300) {
            return 29.75;
        } else if ($peso >= 300 && $peso <= 500) {
            return 30.55;
        } else if ($peso >= 500 && $peso <= 1000) {
            return 34.40;
        } else if ($peso >= 1000 && $peso <= 2000) {
            return 40.65;
        } else if ($peso >= 2000 && $peso <= 3000) {
            return 51;
        } else if ($peso >= 3000 && $peso <= 4000) {
            return 51.50;
        } else if ($peso >= 4000 && $peso <= 5000) {
            return 52;
        } else if ($peso >= 5000 && $peso <= 9000) {
            return 63.70;
        } else if ($peso >= 9000 && $peso <= 13000) {
            return 92;
        } else if ($peso >= 13000 && $peso <= 17000) {
            return 121.65;
        } else if ($peso >= 17000 && $peso <= 23000) {
            return 136.45;
        } else if ($peso >= 23000 && $peso <= 30000) {
            return 142.25;
        } else if ($peso >= 30000 && $peso <= 40000) {
            return 145.90;
        } else if ($peso >= 40000 && $peso <= 50000) {
            return 151.20;
        } else if ($peso >= 50000 && $peso <= 60000) {
            return 162.40;
        } else if ($peso >= 60000 && $peso <= 70000) {
            return 176.55;
        } else if ($peso >= 70000 && $peso <= 80000) {
            return 189.25;
        } else if ($peso >= 80000 && $peso <= 90000) {
            return 201.75;
        }
    }

    public function CalculoCubico($id)
    {

        // CALCULO DO PESO CUBICO
        $cubico = Produtos::where('sku', $id)->first();
        $altura = isset($cubico->altura) ? $cubico->altura : 0;
        $largura = isset($cubico->largura) ? $cubico->altura : 0;
        $comprimento = isset($cubico->comprimento) ? $cubico->altura : 0;

        $total = (($altura * $largura * $comprimento) / SELF::DIVISOR) * 1000;

        // VERIFICA PESO MAIOR
        if ($total <= 2000) {
            return $cubico->Peso;
        } else if ($total > 2000 && $total > $cubico->peso) {
            return $total;
        } else if ($total > 2000 && $total < $cubico->peso) {
            return $cubico->peso;
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

    /**
     * Set the value of precoUnit
     */
    public function setPrecoUnit($precoUnit): self
    {
        $this->precoUnit = $precoUnit;

        return $this;
    }

    /**
     * Get the value of nome
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Get the value of codigo
     */
    public function getCodigo()
    {
        return $this->codigo;
    }
}