<?php

namespace App\Imports;

use App\Models\table_produtos_locais;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class table_produtos_locaisImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
  
        return new table_produtos_locais([
                'sku' => $row['sku'],
                'titulo' => $row['titulo'],
                'preco' => $row['preco'],
                'preco_promocional' => $row['precoPromocional'],
                'data_inicial_promocao' => $row['dataInicialPromocao'],
                'data_final_promocao' => $row['dataFinalPromocao'],
                'estoque' => $row['estoque'],
                'peso_bruto' => $row['pesoBruto'],
                'largura' => $row['largura'],
                'altura' => $row['altura'],
                'comprimento' => $row['comprimento'],
                'data_alteracao' => $row['data_alteracao'],
        ]);
    }
}
