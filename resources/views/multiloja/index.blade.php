@extends('layouts.layout')
@section('conteudo')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="container mt-4">
        @if (count($lojas) <= 0)
            <div class="alert alert-danger text-center" role="alert">
                Não Há Lojas Cadastradas! <a href="{{ route('multiloja.create') }}"> Cadastre a Primeira </a>
            </div>
        @else
            <div class="list-group">
                <a href="{{ route('multiloja.index') }}" class="list-group-item list-group-item-action active">
                    <strong>Lista de Lojas Integradas</strong>
                </a>

                <!--- MENSAGEM DE CONFIRMAÇÂO DE SUCESSO --->
                @if (session('msg'))
                    <div class="alert alert-success" role="alert">
                        {{ session('msg') }}
                    </div>
                @endif
                <!--- FIM MENSAGEM DE CONFIRMAÇÂO DE SUCESSO --->


                <!--- BUSCA PRODUTO NO BANCO --->
                <form action="{{ route('multiloja.index') }}" method="GET" class="mt-3">
                    <div class="form-group col">
                        <label for="inputEmail4">Código da Loja</label>
                        <input type="number" name="loja" class="form-control" id="inputEmail4"
                            placeholder="Digite o Id da Loja">
                    </div>
                </form>


                <div class="container mt-4">
                    <a class="btn btn-success" href="{{ route('multiloja.create') }}"> Cadastrar Nova Loja </a>
                </div>

                <!--- FIM BUSCA PRODUTO NO BANCO --->
                <div id="msgHub"></div>

                <table class="table table-hover mt-2">
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>ID LOJA</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>
                    @foreach ($lojas as $loja)
                        <tr>
                            <td id="id">{{ $loja->id }}</td>
                            <td>{{ $loja->name }}</td>
                            <td>{{ $loja->idmultiloja }}</td>
                            <td><a class="btn btn-warning"
                                    href="{{ route('multiloja.edit', ['id' => $loja->id]) }}">Editar</a></td>
                            <td>
                                <form action="{{ route('multiloja.destroy', ['id' => $loja->id]) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="submit" class="btn btn-danger" value="Apagar">
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </table>
                <div class="d-flex">
                    {{ $lojas->links('pagination::bootstrap-4') }}
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
                        $("#msgHub").html("<div class='alert alert-success text-center'><strong>" +
                            response.dados + "</strong></div>");
                        $('#msgHub').slideUp(2000);
                    },
                    error: function(error) {
                        $("#msgHub").html("<div class='alert alert-danger'>" + error + "</div>");
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
