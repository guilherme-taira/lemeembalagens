<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use App\Models\multiloja;
use Illuminate\Http\Request;

class multilojaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        $lojas = multiloja::paginate(10);

        if(!empty($request->loja)){

            $lojas = multiloja::where('idmultiloja',$request->loja)->paginate(10);

            return view('multiloja.index',[
                "lojas" => $lojas
            ]);
        }

        return view('multiloja.index',[
            'lojas' => $lojas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('multiloja.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $verificador = multiloja::where('idmultiloja',$request->loja)->first();

        if($verificador){
            return redirect()->back()->with('msg',"Loja Já Cadastrada!");
        }

        $loja = new multiloja();
        $loja->name = $request->nome;
        $loja->idmultiloja = $request->loja;
        $salvar = $loja->save();
        if($salvar){
            return redirect()->route('multiloja.index')->with('msg',"Loja Cadastrada com Sucesso!");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loja = multiloja::where('id',$id)->first();

        return view('produtos.edit',[
            "produto" => $loja
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
        $loja = multiloja::where('id',$id)->first();

        return view('multiloja.edit',[
            "loja" => $loja
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {    
                multiloja::where('id',$id)->update(['name' => $request->nome, 'idmultiloja' => $request->loja]);
                // \App\Jobs\atualizaProduto::dispatch($request->sku,$request->valor,floatval($request->stock))->delay(now()->addSeconds('5'));
                return redirect()->route('multiloja.index')->with('msg',"Loja {$request->nome} Editado Com Sucesso!");
          
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
        multiloja::where('id',$id)->delete();
        return redirect()->route('multiloja.index')->with('msg',"Loja Apagada Com Sucesso!");
    }
}