<?php

namespace App\Http\Controllers\Bling\Cadastrar;

use App\Http\Controllers\Controller;
use App\Models\Produtos;
use App\Models\table_produtos_locais;
use Illuminate\Http\Request;

class SobeCadastroController extends AbstractCadastroController
{
    const URL_BASE_PRODUTO_BLING = "https://bling.com.br/";

    public function get($resource){

        try {
            // ENDPOINT PARA REQUISIÇÂO
          $endpoint = self::URL_BASE_PRODUTO_BLING.$resource;
     
          // XML COM DADOS PARA ATUALIZAR 

          $xml = "
          <?xml version='1.0' encoding='UTF-8'?>
          <produto>
              <codigo>{$this->getProduto()->getCodigo()}</codigo>
              <descricao>{$this->getProduto()->getDescricao()}</descricao>
              <tipo>{$this->getProduto()->getTipo()}</tipo>
              <peso_bruto>{$this->getProduto()->getPesoBruto()}</peso_bruto>
              <peso_liq>{$this->getProduto()->getPesoLiq()}</peso_liq>
              <estoque>{$this->getProduto()->getEstoque()}</estoque>
              <vlr_unit>{$this->getProduto()->getVlrUnit()}</vlr_unit>
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
            foreach (json_decode($response)->retorno->produtos as $key => $value) {
                table_produtos_locais::where('sku',$this->getProduto()->getCodigo())->update(['id_bling' => $value->produto->id, 'INTEGRADO' => 'X','PREPARADO' => '']);
            }
          }else{
              return "Error ao Atualizar o produto! Error -> ". $httpCode;
          }

        } catch (\Exception $th) {
            echo $th->getMessage();
        }
          
    }


    public function resource(){
        $this->get('Api/v2/produto/json');
    }
}
