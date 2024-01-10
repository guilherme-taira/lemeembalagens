<?php

namespace App\Http\Controllers\Bling\Cadastrar;

use App\Http\Controllers\Bling\ProductController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class AbstractCadastroController extends Controller
{
    private ProductController $produto;
    private $apikey;

    public function __construct(ProductController $produto, $apikey)
    {
        $this->produto = $produto;
        $this->apikey = $apikey;
    }

    public abstract function get($resource);
    public abstract function resource();

    /**
     * Get the value of produto
     */
    public function getProduto(): ProductController
    {
        return $this->produto;
    }

    /**
     * Set the value of produto
     */
    public function setProduto(ProductController $produto): self
    {
        $this->produto = $produto;

        return $this;
    }

    /**
     * Get the value of apikey
     */
    public function getApikey()
    {
        return $this->apikey;
    }

    /**
     * Set the value of apikey
     */
    public function setApikey($apikey): self
    {
        $this->apikey = $apikey;

        return $this;
    }
}
