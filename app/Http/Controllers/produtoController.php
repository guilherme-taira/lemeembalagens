<?php

namespace App\Http\Controllers;
set_time_limit(0);
use App\Http\Controllers\Bling\GetProdutosApiBlingController;
use App\Http\Controllers\Bling\JobGetProductController;
use App\Http\Controllers\Bling\UpdateSecoundProductController;
use App\Models\Produtos;
use Illuminate\Http\Request;


class produtoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // echo "<pre>";
        // $produto = new GetProdutosApiBlingController('41dee937f0a15eda696a5c3755c037f7d09fb7527237b88ada88d94df99529b640302f27');
        // $produto->resource();

        // $getIds = new JobGetProductController();
        // $getIds->MarketplacesJobs();

        $products = Produtos::paginate(10);

        if(!empty($request->sku)){

            $products = Produtos::where('sku',$request->sku)->paginate(10);

            return view('produtos.index',[
                "products" => $products
            ]);
        }

        return view('produtos.index',[
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Produtos $produto)
    {
        $produto = Produtos::where('id',$produto->id)->first();

        return view('produtos.edit',[
            "produto" => $produto
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produtos $produto)
    {
          try {
            $produto->nome = $request->nome;
            $produto->saldo = $request->stock;
            $produto->secundario = $request->secundario;
            $produto->desconto = $request->desconto;
            $produto->valor = $request->valor;
            $produto->QTDBAIXA = $request->qtdbaixa;
            $produto->sku = $request->sku;
            $produto->ativo = $request->status;
            $produto->dataInicial = $request->datainicial;
            $produto->dataFinal = $request->datafinal;
            $produto->ValorPromocional = $request->valPromocao;
            $success = $produto->save();

            if($success == 1){
                // atualiza o saldo e valor do secundario
                $UpdateSecundario = new UpdateSecoundProductController();
                $UpdateSecundario->UpdateValoresSecundario($request->sku,floatval($request->stock),$request->qtdbaixa,$request->valor);

                // COLOCA NA FILA
                \App\Jobs\atualizaProduto::dispatch($request->sku,$request->valor,floatval($request->stock))->delay(now()->addSeconds('5'));
                return redirect()->route('produtos.index')->with('msg',"Produto {$request->nome} Editado Com Sucesso!");
            }else{
                echo "erro ao editar o cadastro";
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
