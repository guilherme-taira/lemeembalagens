@extends('layouts.layout')
@section('conteudo')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="container mt-4">
        @if (count($products) <= 0)
            <div class="alert alert-danger text-center" role="alert">
                Não Há Produtos Cadastrados!
            </div>
        @else
            <div class="list-group">
                <a href="{{ route('produtos.index') }}" class="list-group-item list-group-item-action active">
                    <strong>Lista de Produtos Bling Máximo Produtos </strong>
                </a>
                <!--- MENSAGEM DE CONFIRMAÇÂO DE SUCESSO --->
                @if (session('msg'))
                    <div class="alert alert-success" role="alert">
                        {{ session('msg') }}
                    </div>
                @endif
                <!--- FIM MENSAGEM DE CONFIRMAÇÂO DE SUCESSO --->


                <!--- BUSCA PRODUTO NO BANCO --->
                <form action="{{ route('produtos.index') }}" method="GET" class="mt-3">
                    <div class="form-group col">
                        <label for="inputEmail4">Código Interno / SKU</label>
                        <input type="number" name="sku" class="form-control" id="inputEmail4" placeholder="Digite o SKU">
                    </div>
                </form>

                <!--- FIM BUSCA PRODUTO NO BANCO --->
                <div id="msgHub"></div>

                <table class="table table-hover mt-2">
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Código</th>
                        <th>Valor</th>
                        <th>Estoque</th>
                        <th>Item Baixados</th>
                        <th>Status</th>
                        <th>Carga</th>
                    </tr>
                    @foreach ($products as $produtos)
                        <tr>
                            <td id="id">{{ $produtos->id }}</td>
                            <td><a class="text-decoration-none" href="{{ route('produtos.show', ['produto' => $produtos->id]) }}">{{ $produtos->nome }}</a></td>
                            <td>{{ $produtos->sku }}</td>
                            <td>R$: {{ $produtos->valor }}</td>
                            <td>{{ $produtos->saldo }}</td>
                            <td>{{ $produtos->QTDBAIXA }}</td>
                            @if ($produtos->ativo != 'Ativo')
                                <td><span class="badge bg-danger float-end">INATIVO</span></td>
                            @else
                                <td><span class="badge bg-success float-end">ATIVO</span></td>
                            @endif
                            <td><button class="btn btn-warning" id="enviado">{{ $produtos->id }}</button></td>
                        </tr>
                    @endforeach
                </table>
                <div class="d-flex">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
                <hr>
            </div>
        @endif
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.theme.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {

            $("msgHub").hide();


            function botaofn(e) {

                var valor = $(this).text();

                if ($(this).find('.btn btn-success')) {
                    console.log(valor);
                    setTimeout(() => {
                        $(this).html(valor);
                    }, 3000);
                }

                $(this).html(
                    "<button class='badge bg-success' disabled><i class='bi bi-lightning-charge'></i></button>");

                let _token = $('meta[name="csrf-token"]').attr('content');
                // REQUISICAO AJAX PARA ATIVAR NO BANCO

                $.ajax({
                    url: "/posthubCarga",
                    type: "POST",
                    data: {
                        sku: valor,
                        _token: _token
                    },
                    success: function(response) {
                        $('#msgHub').slideDown(1000);
                        $("#msgHub").html("<div class='alert alert-success text-center'><strong>" + response.dados +"</strong></div>");
                        $('#msgHub').slideUp(2000);
                    },
                    error: function(error) {
                        $("#msgHub").html("<div class='alert alert-danger'>" + error +"</div>");
                        $('#msgHub').hide(2000);
                    }
                });

                e.preventDefault();
            }

            var botao = document.querySelectorAll('#enviado');
            for (var i = 0; i < botao.length; i++) {
                botao[i].addEventListener('click', botaofn);
            }
            // $("#enviado").removeClass('btn btn-danger').addClass('btn btn-success').attr('value','Ativado');
        });
    </script>
    </div>
@stop
