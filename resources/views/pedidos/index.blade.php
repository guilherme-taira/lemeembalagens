@extends('layouts.layout')
@section('conteudo')
    <div class="container mt-4">

        @if (count($pedidos) <= 0)
            <div class="alert alert-danger text-center" role="alert">
                Não Há Pedidos Cadastrados!
            </div>
        @endif

        <div class="container">
            <h1>Pedidos</h1>
            <ul class="list-group m2">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Número</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Data</th>
                            <th scope="col">Total Venda R$</th>
                            <th scope="col">Local</th>
                        </tr>
                    </thead>
                    <tbody>
                        <li class="list-group-item active" aria-current="true">Pedidos</li>
                        @foreach ($pedidos as $pedido)
                        <tr>
                            <th scope="row">{{$pedido->n_order}}</th>
                            <td>{{$pedido->cliente}}</td>
                            <td>{{$pedido->created_at}}</td>
                            <td>{{$pedido->valor_total}}</td>
                            <td><img src='{{ asset('images/logos/shopee.svg') }}' style="width: 16px; height:16px"></td>
                        </tr>
                            
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex">
                    {{ $pedidos->links('pagination::bootstrap-4') }}
                </div>
        </div>

    </div>
@endsection
