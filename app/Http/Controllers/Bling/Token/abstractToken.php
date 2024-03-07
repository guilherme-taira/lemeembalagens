<?php

namespace App\Http\Controllers\Bling\Token;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class abstractToken extends Controller
{
    const URL_BASE = "https://www.bling.com.br";

    private $client_id;
    private $client_secret;
    private $refresh_token;
    private $tokens;

    public function __construct($client_id,$client_secret,$refresh_token,$tokens)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->refresh_token = $refresh_token;
        $this->tokens = $tokens;
    }
    
     abstract public function resource();
     abstract public function get($resource);
     abstract public function gerarBase64($string1, $string2);

    /**
     * Get the value of refresh_token
     */
    public function getRefreshToken()
    {
        return $this->refresh_token;
    }

    /**
     * Get the value of client_secret
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    /**
     * Get the value of client_id
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * Get the value of tokens
     */
    public function getTokens()
    {
        return $this->tokens;
    }
}
