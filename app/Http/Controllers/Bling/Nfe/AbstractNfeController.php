<?php

namespace App\Http\Controllers\Bling\Nfe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class AbstractNfeController extends Controller
{
    // CONTROLLER PEDIDO
    private $pedido;
    private $finalizade = 1;
    private $loja;
    private $numero_loja;

    // INFORMACOES CLIENTE
    private $nome;
    private $tipo_pessoa;
    private $cpf_cnpj;
    private $contribuinte;
    private $endereco;
    private $numero;
    private $complemento;
    private $bairro;
    private $cep;
    private $cidade;
    private $uf;
    private $fone;
    private $email;
    // INFORMACOES DE VOLUME
    private $servico;
    private $codigoRastreamento;
    // INFORMAÇÕES DOS ITEM
    private $codigoItem;
    private $itemDescricao;
    private $un = 'un';
    private $qtde;
    private $vlr_unit;
    private $tipo = "P";
    private $origem = 1;
       
    public function __construct($pedido,$finalizade,$loja,$numero_loja,$nome,$tipo_pessoa,$cpf_cnpj,$contribuinte,$endereco,$numero
    ,$complemento,$bairro,$cep,$cidade,$uf,$fone,$email,$servico,$codigoRastreamento,$codigoItem,$itemDescricao,
    $un,$qtde,$vlr_unit,$tipo,$origem)
    {

        $this->pedido = $pedido;
        $this->finalizade = $finalizade;
        $this->loja = $loja;
        $this->numero_loja = $numero_loja;
        $this->tipo_pessoa = $tipo_pessoa;
        $this->cpf_cnpj = $cpf_cnpj;
        $this->contribuinte = $contribuinte;
        $this->endereco = $endereco;
        $this->numero = $numero;
        $this->complemento = $complemento;
        $this->bairro = $bairro;
        $this->cep = $cep;
        $this->cidade = $cidade;
        $this->uf = $uf;
        $this->fone = $fone;
        $this->email = $email;
        $this->servico = $servico;
        $this->codigoRastreamento = $codigoRastreamento;
        $this->codigoItem = $codigoItem;
        $this->itemDescricao = $itemDescricao;
        $this->un = $un;
        $this->qtde = $qtde;
        $this->vlr_unit = $vlr_unit;
        $this->tipo = $tipo;
        $this->origem = $origem;
    }

    abstract function resource();
    abstract function get($resource);


    /**
     * Get the value of pedido
     */
    public function getPedido()
    {
        return $this->pedido;
    }

    /**
     * Get the value of finalizade
     */
    public function getFinalizade()
    {
        return $this->finalizade;
    }

    /**
     * Set the value of finalizade
     */
    public function setFinalizade($finalizade): self
    {
        $this->finalizade = $finalizade;

        return $this;
    }

    /**
     * Get the value of numero_loja
     */
    public function getNumeroLoja()
    {
        return $this->numero_loja;
    }

    /**
     * Set the value of numero_loja
     */
    public function setNumeroLoja($numero_loja): self
    {
        $this->numero_loja = $numero_loja;

        return $this;
    }

    /**
     * Get the value of loja
     */
    public function getLoja()
    {
        return $this->loja;
    }

    /**
     * Set the value of loja
     */
    public function setLoja($loja): self
    {
        $this->loja = $loja;

        return $this;
    }

    /**
     * Get the value of nome
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     */
    public function setNome($nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of tipo_pessoa
     */
    public function getTipoPessoa()
    {
        return $this->tipo_pessoa;
    }

    /**
     * Set the value of tipo_pessoa
     */
    public function setTipoPessoa($tipo_pessoa): self
    {
        $this->tipo_pessoa = $tipo_pessoa;

        return $this;
    }

    /**
     * Get the value of cpf_cnpj
     */
    public function getCpfCnpj()
    {
        return $this->cpf_cnpj;
    }

    /**
     * Set the value of cpf_cnpj
     */
    public function setCpfCnpj($cpf_cnpj): self
    {
        $this->cpf_cnpj = $cpf_cnpj;

        return $this;
    }

    /**
     * Get the value of contribuinte
     */
    public function getContribuinte()
    {
        return $this->contribuinte;
    }

    /**
     * Set the value of contribuinte
     */
    public function setContribuinte($contribuinte): self
    {
        $this->contribuinte = $contribuinte;

        return $this;
    }

    /**
     * Get the value of endereco
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * Set the value of endereco
     */
    public function setEndereco($endereco): self
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * Get the value of complemento
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * Set the value of complemento
     */
    public function setComplemento($complemento): self
    {
        $this->complemento = $complemento;

        return $this;
    }

    /**
     * Get the value of numero
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set the value of numero
     */
    public function setNumero($numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get the value of bairro
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * Set the value of bairro
     */
    public function setBairro($bairro): self
    {
        $this->bairro = $bairro;

        return $this;
    }

    /**
     * Get the value of cep
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set the value of cep
     */
    public function setCep($cep): self
    {
        $this->cep = $cep;

        return $this;
    }

    /**
     * Get the value of cidade
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * Set the value of cidade
     */
    public function setCidade($cidade): self
    {
        $this->cidade = $cidade;

        return $this;
    }

    /**
     * Get the value of uf
     */
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * Set the value of uf
     */
    public function setUf($uf): self
    {
        $this->uf = $uf;

        return $this;
    }

    /**
     * Get the value of fone
     */
    public function getFone()
    {
        return $this->fone;
    }

    /**
     * Set the value of fone
     */
    public function setFone($fone): self
    {
        $this->fone = $fone;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of servico
     */
    public function getServico()
    {
        return $this->servico;
    }

    /**
     * Set the value of servico
     */
    public function setServico($servico): self
    {
        $this->servico = $servico;

        return $this;
    }

    /**
     * Get the value of codigoRastreamento
     */
    public function getCodigoRastreamento()
    {
        return $this->codigoRastreamento;
    }

    /**
     * Set the value of codigoRastreamento
     */
    public function setCodigoRastreamento($codigoRastreamento): self
    {
        $this->codigoRastreamento = $codigoRastreamento;

        return $this;
    }

    /**
     * Get the value of codigoItem
     */
    public function getCodigoItem()
    {
        return $this->codigoItem;
    }

    /**
     * Set the value of codigoItem
     */
    public function setCodigoItem($codigoItem): self
    {
        $this->codigoItem = $codigoItem;

        return $this;
    }

    /**
     * Get the value of itemDescricao
     */
    public function getItemDescricao()
    {
        return $this->itemDescricao;
    }

    /**
     * Set the value of itemDescricao
     */
    public function setItemDescricao($itemDescricao): self
    {
        $this->itemDescricao = $itemDescricao;

        return $this;
    }

    /**
     * Get the value of un
     */
    public function getUn()
    {
        return $this->un;
    }

    /**
     * Set the value of un
     */
    public function setUn($un): self
    {
        $this->un = $un;

        return $this;
    }

    /**
     * Get the value of qtde
     */
    public function getQtde()
    {
        return $this->qtde;
    }

    /**
     * Set the value of qtde
     */
    public function setQtde($qtde): self
    {
        $this->qtde = $qtde;

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
     * Get the value of tipo
     */
    public function getTipo()
    {
        return $this->tipo;
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
     * Get the value of origem
     */
    public function getOrigem()
    {
        return $this->origem;
    }

    /**
     * Set the value of origem
     */
    public function setOrigem($origem): self
    {
        $this->origem = $origem;

        return $this;
    }
}
