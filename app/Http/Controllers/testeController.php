<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Bling\GetProdutosApiBlingController;
use App\Http\Controllers\Bling\Nfe\NfeController;
use App\Http\Controllers\Bling\Token\TokenControllerImplement;
use App\Models\token;
use Illuminate\Http\Request;

class testeController extends Controller
{
    public function teste()
    {
        echo "<h1> NOTA FISCAL </h1>";

       
        $client = env('CLIENT_ID');
        echo $client;
        // $token = token::first();
        // $refreshToken = new TokenControllerImplement(env('CLIENT_ID'),env('CLIENT_SECRET'),$token->refresh_token);
        // $refreshToken->resource();
    }
}
