<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class EstoqueDTO extends Controller
{
    private $id_produto;
    private $quantidade;

    public function __construct($id_produto,$quantidade)
    {
        $this->id_produto = $id_produto;
        $this->quantidade = $quantidade;
    }

    public function toJson(){

        $data = [
            "deposito" => ["id" => "14887584579"],
            "operacao" => "B",
            "produto" => ["id" => $this->getIdProduto()],
            "quantidade" => "{$this->getQuantidade()}",
            "observacoes" => "Estoque Atualizado",
        ];
        return json_encode($data);
    }

    public function toJsonEstoque(){
        $data = [
            'quantidade' => $this->getQuantidade(),
            "operacao" => "B",
        ];

        return json_encode($data);
    }

    public function toObjet(){
        return json_decode($this->toJson());
    }
    /**
     * Get the value of id_produto
     */
    public function getIdProduto()
    {
        return $this->id_produto;
    }

    /**
     * Get the value of quantidade
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }
}
