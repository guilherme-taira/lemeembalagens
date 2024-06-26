<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Bling\Cadastrar\SobeCadastroController;
use App\Http\Controllers\Bling\GetProdutosApiBlingController;
use App\Http\Controllers\Bling\GetProdutosLojasApiBlingController;
use App\Http\Controllers\Bling\Hub\ProdutoFactory;
use App\Http\Controllers\Bling\ProductController;
use App\Http\Controllers\Bling\PutProdutoController;
use App\Models\Produtos;
use App\Models\table_produtos_locais;
use DateTime;
use Illuminate\Http\Request;

class HubController extends Controller
{
    public function Hub(){

      $produto = new GetProdutosApiBlingController('1aeeb29ae86d4f320c8fbce3a893e23b187121e46d88590d3dcf37f53ff771c23b0ce90a');
      $produto->resource();

      $produtolojas = new GetProdutosLojasApiBlingController();
      $produtolojas->resource();

      $produtos = table_produtos_locais::where('PREPARADO',"X")->get();
      foreach ($produtos as $value) {
        $data = new ProductController($value->sku);
        $dados = new SobeCadastroController($data,'1aeeb29ae86d4f320c8fbce3a893e23b187121e46d88590d3dcf37f53ff771c23b0ce90a');
        $dados->resource();
      }
            
      try {
        $produtos = table_produtos_locais::where('flag',"X")->get();
        foreach ($produtos as $produto) {
            $DataInicialPromocao = DateTime::createFromFormat('Y-m-d', $produto['dataInicial']);
            $DataFinalPromocao = DateTime::createFromFormat('Y-m-d', $produto['dataFinal']);
            $FactoryProduto = new ProdutoFactory();
            $FactoryProduto->VerificaPromocao($produto->id_bling, floatval($produto->valorPromocional), floatval($produto->valor), $produto->saldo, $DataInicialPromocao, $DataFinalPromocao, $produto->ativo, $produto->QTDBAIXA, 0,$produto->nome,$produto->sku);
        
        } 
      } catch (\Exception $e) {
        echo $e->getMessage();
      } 
      
        return view('hub.index');
    }
}
