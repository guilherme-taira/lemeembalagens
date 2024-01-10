<?php

use App\Http\Controllers\Bling\ajaxCargaBlingController;
use App\Http\Controllers\Bling\PedidosController;
use App\Http\Controllers\Financeiro\FinancesController;
use App\Http\Controllers\Financeiro\GetFormDataAjax;
use App\Http\Controllers\HubController;
use App\Http\Controllers\produtoController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\DataCollector\AjaxDataCollector;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layouts/index');
})->name('index');

/**
 * ROTAS DE PRODUTOS
 * 
 * **/

// ROTA PARA CADASTRAR PRODUTOS 
Route::get('/teste',[produtoController::class,'teste']);
Route::get('/hub',[HubController::class,'hub'])->name('hub.index');
Route::get('/getInformationFinance',[GetFormDataAjax::class,'getData'])->name('GetformAjaxFinance');
Route::get('/getProductsOrder',[GetFormDataAjax::class,'getProducts'])->name('GetProductsOrder');

// ROTAS RESOURCE
Route::resource('/produtos', 'App\Http\Controllers\produtoController')->names('produtos')->parameters(['produto' => 'id']);
Route::resource('/pedidos', 'App\Http\Controllers\Bling\PedidosController')->names('pedidos')->parameters(['pedidos' => 'id']);
Route::resource('/financeiro','App\Http\Controllers\Financeiro\FinancesController')->names('financeiro')->parameters(['financeiro'=> 'id']);


// ROTAS POST
Route::post('/posthubCarga',[ajaxCargaBlingController::class,'Carga'])->name('bling.carga');

