<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use DateTime;
use Illuminate\Http\Request;

class FinancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $dateMounth = new DateTime();
        $Soma = Orders::SumMonth($dateMounth);
        $countOrder = Orders::CountOrders($dateMounth);

        // DECLARAÇÃO DO MÊS ATUAL EM SESSÃO
        session()->put('mouth',$dateMounth->format('Y-M'));

        $dataView = [];
        $dataView['Company'] = "Vidro Nobre";
        $dataView['Month'] = $dateMounth->format('Y-m');
        $dataView['TotalMounth'] = number_format($Soma,2,",",".");
        $dataView['TotalOrders'] = isset($countOrder) ? $countOrder : 0;
        $dataView['Comission'] = $this->calculateComission(isset($Soma)? $Soma : 0);
        return view('financeiro.index')->with('dataView',$dataView);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $orders = Orders::where('created_at','Like', '%'. $request->id .'%')->paginate(20);

        return view('financeiro.orders')->with('orders',$orders);
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
    public function update(Request $request, $id)
    {
        //
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

    public function calculateComission(float $value){
        $total = $value * 0.05;
        return number_format($total,3);
    }
}
