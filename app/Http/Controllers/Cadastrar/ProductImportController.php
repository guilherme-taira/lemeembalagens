<?php

namespace App\Http\Controllers\Cadastrar;

use App\Http\Controllers\Controller;
use App\Imports\table_produtos_locaisImport;
use App\Models\Produtos;
use App\Models\table_produtos_locais;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Facades\Excel;

class ProductImportController extends Controller
{

    public function importdata(){
        return view('hub.import');
    }
    
    public function import(Request $request)
    {
        // Validação do arquivo
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Recebendo o arquivo
        $file = $request->file('file');

        // Lendo o arquivo Excel
        $excel = Excel::toArray(null, $file);
        // Iterando sobre as linhas do Excel
        
        foreach ($excel as $key => $rows) {
            unset($rows[0]);
            foreach ($rows as $key => $row) {

                try {
                    $newProduct = table_produtos_locais::IfExists($row[0]);
                if(!$newProduct){
                    $newProduto = new table_produtos_locais;
                    $newProduto->sku = $row[0];
                    $newProduto->nome = $row[2];
                    $newProduto->valor = $row[3];
                    $newProduto->valorPromocional = $row[4];
                    $newProduto->dataInicial = $row[5];
                    $newProduto->dataFinal = $row[6];
                    $newProduto->saldo = $row[7];
                    $newProduto->peso = $row[8];
                    $newProduto->largura = $row[9];
                    $newProduto->altura = $row[10];
                    $newProduto->comprimento = $row[11];
                    $newProduto->save();
                }else{
                    table_produtos_locais::updatedProduct($row);
                }
                } catch (\Exception $th) {
                    return redirect()->back()->with('alert', 'Error ao importar os Produtos! :' . $th->getMessage());
                }
            }
            break;
        }

        return redirect()->back()->with('success', 'Planilha importada com sucesso!');
    }

}