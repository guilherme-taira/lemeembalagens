<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use App\Models\items;
use App\Models\Orders;
use DateTime;
use Illuminate\Http\Request;

interface OrdersBling
{
    public function resource();
    public function get($resource);
}

class GetOrderController implements OrdersBling
{
    const URL_BASE_GET_ORDERS_BLING = "https://bling.com.br/Api/v2/";

    private $pagina;
    private $dataInicial;
    private $dataFinal;
    private $apikey;

    public function __construct($pagina, DateTime $dataInicial, DateTime $dataFinal, $apikey)
    {
        $this->pagina = $pagina;
        $this->dataInicial = $dataInicial;
        $this->dataFinal = $dataFinal;
        $this->apikey = $apikey;
    }

    public function resource()
    {
        return $this->get("pedidos/page={$this->getPagina()}/json/");
    }

    public function get($resource)
    {

        // FILTER
        $filter = "dataEmissao[{$this->DataInicialAmerica($this->getDataInicial())}TO{$this->DataFinalAmerica($this->getDataInicial())}]";

        // ENDPOING PARA REQUISICAO
        $endpoint = self::URL_BASE_GET_ORDERS_BLING . $resource;

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $endpoint . '&filters=' . $filter . '&apikey=' . $this->getApikey());
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($curl_handle);
        curl_close($curl_handle);
        $jsonDecodificado = json_decode($response);
        echo "<pre>";
        foreach ($jsonDecodificado->retorno->pedidos as $pedido) {
            print_r($pedido);
            $save = new Orders();
            $save->n_order = $pedido->pedido->numero;
            $save->cliente = $pedido->pedido->cliente->nome;
            $save->frete = $pedido->pedido->valorfrete;
            $save->valor_total = $pedido->pedido->totalvenda;
            $save->marketplace = $pedido->pedido->tipoIntegracao;
            $save->save();
            foreach ($pedido->pedido->itens as $item) {
                // FUNCAO RETIRA DO SALDO
                // $RetiraSaldoController = new RetiraSaldoController();
                // $RetiraSaldoController->Produto(isset($item->item->codigo)?$item->item->codigo:0,$item->item->quantidade);
            $produto = new items();
            $produto->id_product = isset($item->item->codigo)?$item->item->codigo:0;
            $produto->quantidade = isset($item->item->quantidade)?$item->item->quantidade:0;
            $produto->price = isset($item->item->valorunidade)?$item->item->valorunidade:0;
            $produto->n_order = $save->id;
            $produto->flag_baixa = "X";
            $produto->save();
            //print_r($item);
            }    
        }
    }

    public function DataInicialAmerica(DateTime $data)
    {

        $data = new DateTime();
        $data->modify('-10 days');
        $patterns = array('/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/', '/^\s*{(\w+)}\s*=/');
        $replace = array('\4/\3/\1\2', '$\1 =');

        return preg_replace($patterns, $replace, $data->format('Y-m-d'));
    }

    public function DataFinalAmerica(DateTime $data)
    {

        $data = new DateTime();
        $data->modify('+2 days');
        $patterns = array('/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/', '/^\s*{(\w+)}\s*=/');
        $replace = array('\4/\3/\1\2', '$\1 =');

        return preg_replace($patterns, $replace, $data->format('Y-m-d'));
    }


    /**
     * Get the value of pagina
     */
    public function getPagina()
    {
        return $this->pagina;
    }

    /**
     * Get the value of dataInicial
     */
    public function getDataInicial()
    {
        return $this->dataInicial;
    }

    /**
     * Get the value of dataFinal
     */
    public function getDataFinal()
    {
        return $this->dataFinal;
    }

    /**
     * Get the value of apikey
     */
    public function getApikey()
    {
        return $this->apikey;
    }
}
