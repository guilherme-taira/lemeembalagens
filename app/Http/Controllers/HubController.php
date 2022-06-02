<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Bling\PutProdutoController;
use Illuminate\Http\Request;

class HubController extends Controller
{
    public function Hub(){
        return view('hub.index');
    }
}
