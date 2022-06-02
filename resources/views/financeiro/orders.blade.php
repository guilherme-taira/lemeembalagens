@extends('layouts.layout')
@section('conteudo')
    <div class="container mt-4 py-2">
        {{-- TABLE --}}
        <div class="content">

            <div class="container">
                <h2 class="mb-5">Vendas Mês Atual</h2>

                <div class="table-responsive">

                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <label class="control control--checkbox">
                                        <input type="checkbox" class="js-check-all" />
                                        <div class="control__indicator"></div>
                                    </label>
                                </th>
                                <th scope="col">Pedido</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Data</th>
                                <th scope="col">Frete</th>
                                <th scope="col">MarketPlace</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <th scope="row">
                                        <label class="control control--checkbox">
                                            <input type="checkbox" />
                                            <div class="control__indicator"></div>
                                        </label>
                                    </th>
                                    <td>{{$order->n_order}}</td>
                                    <td>{{$order->cliente}}</td>
                                    <td>
                                       R$: {{$order->valor_total}}
                                        <small class="d-block">Ver Produtos</small>
                                    </td>
                                    <td>{{$order->created_at}}</td>
                                    <td>{{$order->frete}}</td>
                                    <td>{{$order->marketplace}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>

        </div>
        {{-- FIM TABLE --}}


        <div class="d-flex">
            {{ $orders->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
