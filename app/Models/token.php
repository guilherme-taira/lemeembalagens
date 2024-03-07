<?php

namespace App\Models;

use App\Http\Controllers\Bling\Token\TokenControllerImplement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class token extends Model
{
    use HasFactory;

    protected $table = 'token';

    public static function getToken(){
        
        $token = token::first();
        $refreshToken = new TokenControllerImplement($_ENV['CLIENT_ID'],$_ENV['CLIENT_SECRET'],$token->refresh_token,$token);
        $refreshToken->resource();

        return $token->access_token;
    }
    
    public static function saveToken(Request $request){
        
        try {
            $ifExist = token::first();

            if(!$ifExist){
                $token = new token();
                $token->access_token = $request['access_token'];
                $token->refresh_token = $request['refresh_token'];
                $token->datamodify = token::adicionarMinutosAoTempoAtual($request['expires_in']);
                $token->save();
            }else{
                token::where('id',$ifExist->id)->update([
                    'access_token' => $request['access_token'],
                    'refresh_token' => $request['refresh_token'],
                    'datamodify' => token::adicionarMinutosAoTempoAtual($request['expires_in'])
                ]);
    
            }
               
        } catch (\Exception $th) {
            echo $th->getMessage();
        }
      
    }

    public static function saveTokenArray($request){
        
        try {
            $ifExist = token::first();

            if(!$ifExist){
                $token = new token();
                $token->access_token = $request['access_token'];
                $token->refresh_token = $request['refresh_token'];
                $token->datamodify = token::adicionarMinutosAoTempoAtual($request['expires_in']);
                $token->save();
            }else{
                token::where('id',$ifExist->id)->update([
                    'access_token' => $request['access_token'],
                    'refresh_token' => $request['refresh_token'],
                    'datamodify' => token::adicionarMinutosAoTempoAtual($request['expires_in'])
                ]);
    
            }
               
        } catch (\Exception $th) {
            echo $th->getMessage();
        }
      
    }

    public static function adicionarMinutosAoTempoAtual($milisegundos) {
        // Obtém a hora atual em segundos
        $horaAtual = time();
    
        // Converte milisegundos para minutos
        $minutos = $milisegundos / 60000;
    
        // Adiciona minutos ao tempo atual
        $novoTempo = $horaAtual + ($minutos * 60);
    
        // Retorna o novo tempo em formato de data/hora
        return date('Y-m-d H:i:s', $novoTempo);
    }
   
}