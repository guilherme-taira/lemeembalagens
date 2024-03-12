<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use App\Models\table_produtos_locais;
use App\Models\token;
use Illuminate\Http\Request;

class EstoqueController extends EstoqueDTO
{

    const URL_BASE = "https://www.bling.com.br";

    public function resource()
    {
        return $this->get('/Api/v3/estoques');
    }


    public function get($resource)
    {
        $estoqueExist = table_produtos_locais::where('id_bling', $this->getIdProduto())->first();


        if(!$estoqueExist->id_estoque){
            try {
                // ENDPOINT PARA REQUISICAO
                $endpoint = self::URL_BASE . $resource;
                $ch = curl_init();
            
                $token = token::getToken();
                curl_setopt($ch, CURLOPT_URL, $endpoint);
                // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'Accept: application/json', "Authorization: Bearer $token"]);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->toJson());  
                $response = curl_exec($ch);
                curl_close($ch);
                } catch (\Exception $th) {
                echo $th->getMessage();
            }
        }else{
            try {
                // ENDPOINT PARA REQUISICAO
                $endpoint = self::URL_BASE . $resource;
                $ch = curl_init();
            
                $token = token::getToken();
                curl_setopt($ch, CURLOPT_URL, $endpoint);
                // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'Accept: application/json', "Authorization: Bearer $token"]);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->toJson());  
                $response = curl_exec($ch);
                curl_close($ch);
                } catch (\Exception $th) {
                echo $th->getMessage();
             }
        }   
    }
}