<?php

namespace App\Http\Controllers\Bling\Token;

use App\Http\Controllers\Controller;
use App\Models\token;
use DateTime;
use Illuminate\Http\Request;
date_default_timezone_set('America/Sao_Paulo');

class TokenControllerImplement extends abstractToken
{
    function gerarBase64($string1, $string2) {
        // Concatena as duas strings com um separador
        $concatenado = $string1 . ':' . $string2;
        // Codifica a string concatenada em Base64
        $base64 = base64_encode($concatenado);
        return $base64;
    }

    public function get($resource){

        $data1Obj = new DateTime($this->getTokens()['datamodify']);
        $data2Obj = new DateTime(date('Y-m-d H:i:s'));

        if($data1Obj < $data2Obj){

        // ENDPOINT PARA REQUISICAO
        $endpoint = parent::URL_BASE. $resource;

        $data = array(
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->getRefreshToken()
        );

        $header = [
            'Authorization: Basic ' . $this->gerarBase64($this->getClientId(),$this->getClientSecret()),
            'Content-Type: application/x-www-form-urlencoded', // Exemplo de outro cabeçalho
        ];
    
        // Configuração da requisição cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));  
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        // Execução da requisição
        $res = json_decode($response,true);
            if ($httpCode == 200) {
                token::saveTokenArray($res);
            } else {
                echo 'Erro ao realizar a requisição. Código HTTP: ' . $httpCode;
            }
        }
        
    }

    public function resource(){
        return $this->get("/Api/v3/oauth/token");
    }
}