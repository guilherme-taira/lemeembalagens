<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use App\Models\Produtos;
use DateTime;
use Illuminate\Http\Request;


interface ImplementHub{
    public function JobInteface();
}

class ProdutoHubController implements ImplementHub{

    public function JobInteface()
    {
        $produtos = Produtos::where('flag','X')->get();
    }
}
