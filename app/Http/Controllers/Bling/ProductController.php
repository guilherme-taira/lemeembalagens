<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use App\Models\Produtos;
use App\Models\table_produtos_locais;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $codigo;
    private $descricao;
    private $tipo = "P";
    private $vlr_unit;
    private $peso_bruto;
    private $peso_liq;
    private $estoque;

    public function __construct($codigo)
    {
        $produto = table_produtos_locais::where('sku',$codigo)->first();
        $this->codigo = $produto->sku;
        $this->descricao = $produto->nome;
        $this->tipo = "P";
        $this->vlr_unit = $produto->valor;
        $this->peso_bruto = 0;
        $this->peso_liq = 0;
        $this->estoque = $produto->saldo;
    }

    /**
     * Set the value of codigo
     */
    public function setCodigo($codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Set the value of descricao
     */
    public function setDescricao($descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Set the value of tipo
     */
    public function setTipo($tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of vlr_unit
     */
    public function getVlrUnit()
    {
        return $this->vlr_unit;
    }

    /**
     * Set the value of vlr_unit
     */
    public function setVlrUnit($vlr_unit): self
    {
        $this->vlr_unit = $vlr_unit;

        return $this;
    }

    /**
     * Get the value of peso_bruto
     */
    public function getPesoBruto()
    {
        return $this->peso_bruto;
    }

    /**
     * Set the value of peso_bruto
     */
    public function setPesoBruto($peso_bruto): self
    {
        $this->peso_bruto = $peso_bruto;

        return $this;
    }

    /**
     * Get the value of peso_liq
     */
    public function getPesoLiq()
    {
        return $this->peso_liq;
    }

    /**
     * Set the value of peso_liq
     */
    public function setPesoLiq($peso_liq): self
    {
        $this->peso_liq = $peso_liq;

        return $this;
    }

    /**
     * Get the value of estoque
     */
    public function getEstoque()
    {
        return $this->estoque;
    }

    /**
     * Set the value of estoque
     */
    public function setEstoque($estoque): self
    {
        $this->estoque = $estoque;

        return $this;
    }

    /**
     * Get the value of codigo
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Get the value of descricao
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Get the value of tipo
     */
    public function getTipo()
    {
        return $this->tipo;
    }
}
