<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use App\Models\multiloja;
use App\Models\table_produtos_locais;
use App\Models\token;
use Illuminate\Http\Request;

class GetProdutosLojasApiBlingController extends Controller
{

    public function resource()
    {
        return $this->get('produtos/lojas');
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

        $lojas = multiloja::get();
        foreach ($lojas as $loja) {
            
        // ENDPOINT PARA REQUISICAO
        $endpoint = URL_BASE_API_GET_PRODUTOS_BLING . $resource . "?idLoja=$loja->idmultiloja";
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

        foreach ($produtos as $produto) {
            foreach ($produto as $valores) {
              if(isset($valores->codigo) && $valores->codigo != 0){
                    if($valores->loja->id == $loja->idmultiloja){
                        table_produtos_locais::where('id_bling',$valores->produto->id)->update([$loja->name => $valores->codigo, $this->getLocalLoja($valores->loja->id,$lojas) => $valores->id]);
                    }
              }
            }
        }
    }
          # code...
    }


    public function getLocalLoja($id_loja,$lojas){

        foreach ($lojas as $loja) {
            if($loja->idmultiloja == $id_loja){
                switch ($loja->name) {
                    case 'tray':
                        return "id_tray_loja";

                        case 'id_shopee':
                            return "id_shopee_loja";
                            
                            case 'id_mercadolivre':
                               return "id_mercadolivre_loja";
                }
            }
        }
        
    }

   
}