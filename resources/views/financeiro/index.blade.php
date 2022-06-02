@extends('layouts.layout')
@section('conteudo')
    <div class="container mt-4 py-2">
        <h1>Financeiro</h1>
        <div class="container-fluid">
            <section>
                {{-- ACORDION --}}

                <div class="accordion accordion-flush" id="accordionFlushExample ">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                Filtros de Pesquisa &nbsp; <i class="bi bi-search"></i>
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">

                                <button class="btn btn-primary mt-2" type="button" id="loaderDiv" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>

                                <form class="row g-3 mt-4">
                                    <div class="col-md-6">
                                        <label for="validationServer01" class="form-label">Nome: </label>
                                        <input type="text" class="form-control is-valid name" id="validationServer01">
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="validationServer02" class="form-label">Data Inicial</label>
                                        <input type="date" class="form-control is-valid datainicial"
                                            id="validationServer02">
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="validationServer02" class="form-label">Data Final</label>
                                        <input type="date" class="form-control is-valid datafinal" id="validationServer02">
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <button class="btn btn-primary" type="submit">Submit form</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END ACORDION --}}

                {{-- FILTER RESULT --}}

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Produtos do Pedido</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{-- CONTENT MODEL --}}
                                <table class="table mt-4">
                                    <thead>
                                        <tr>
                                            <th scope="col">id</th>
                                            <th scope="col">Codigo</th>
                                            <th scope="col">Quantidade</th>
                                            <th scope="col">Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody id="rows">
                                        {{-- ITEMS DA REQUISIÇÂO AJAX --}}
                                    </tbody>
                                </table>
                                {{-- END CONTENT MODEL --}}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table mt-4" id="resultFilter">
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Total</th>
                            <th scope="col">Marketplace</th>
                            <th scope="col">Data</th>
                            <th scope="col">Ver</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" id="id"></th>
                            <td id="nome"></td>
                            <td id="total">R$: </td>
                            <td id="mktplace"> </td>
                            <td id="data"></td>
                            <td id="see"><a href="#" id="Products"><button type="button" class="btn btn-primary"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                                            class="bi bi-eye"></i></button></a></td>
                        </tr>
                    </tbody>
                </table>

                {{-- END FILTER RESULT --}}

                {{-- DASHBOARD --}}
                <div class="row">
                    <div class="col-12 mt-3 mb-1">
                        <h5 class="text-uppercase">Métricas de Vendas -> {{ $dataView['Company'] }}</h5>
                        <p>Dados de vendas e do financeiro</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between p-md-1">
                                    <div class="d-flex flex-row">
                                        <div class="align-self-center">
                                            <i class="bi-cart-check fa-3x me-4"
                                                style="font-size: 2rem; color: rgb(2, 196, 76);"></i>
                                        </div>
                                        <div>
                                            <h4><a href="{{ route('financeiro.show', ['id' => $dataView['Month']]) }}">Total
                                                    Vendas</a></h4>
                                            <p class="mb-0">Mês atual</p>
                                        </div>
                                    </div>
                                    <div class="align-self-center">
                                        <h2 class="h1 mb-0 valueMounth">R$: {{ $dataView['TotalMounth'] }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between p-md-1">
                                    <div class="d-flex flex-row">
                                        <div class="align-self-center">
                                            <i class="bi bi-cash-coin fa-3x me-4"
                                                style="font-size: 2rem; color: rgb(221, 245, 7);"></i>
                                        </div>
                                        <div>
                                            <h4>Total Dia</h4>
                                            <p class="mb-0">Valor total do dia</p>
                                        </div>
                                    </div>
                                    <div class="align-self-center">
                                        <h2 class="h1 mb-0 ">R$: 695,00</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between p-md-1">
                                    <div class="d-flex flex-row">
                                        <div class="align-self-center">
                                            <h2 class="h2 mb-0 me-2">R$: {{ $dataView['Comission'] }}</h2>
                                        </div>
                                        <div>
                                            <h4>Comissões </h4>
                                            <p class="mb-2">Total a ser Pago em comissões (5%)</p>
                                        </div>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-coin fa-1x me-2"
                                            style="font-size: 2rem; color: rgb(255, 6, 52);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between p-md-1">
                                    <div class="d-flex flex-row">
                                        <div class="align-self-center">
                                            <h2 class="h1 mb-0 me-4">R$: 8000,00</h2>
                                        </div>
                                        <div>
                                            <h4>Total Líquido</h4>
                                            <p class="mb-0">Total Líquido do Mês</p>
                                        </div>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-currency-dollar text-success fa-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.theme.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
<script>
    $(document).ready(function() {
        // DEFINIÇÂO DE OBJETOS OCULTOS
        $("#loaderDiv").hide();
        $("#resultFilter").hide();

        // REQUISICAO AJAX PARA ATIVAR NO BANCO
        $('form').submit(function(event) {
            event.preventDefault();

            var name = $('.name').val();
            var datainicial = $('.datainicial').val();
            var datafinal = $('.datafinal').val();
            $.ajax({
                url: "/getInformationFinance",
                type: "GET",
                data: {
                    name: name,
                    datainicial: datainicial,
                    datafinal: datafinal
                },
                beforeSend: function() {
                    $("#loaderDiv").show();
                    //$("#resultFilter").html("");
                },
                success: function(response) {
                    console.log(response.dados);
                    $("#loaderDiv").slideUp('slow');
                    var json = $.parseJSON(response.dados);

                    // SHOW TABLE FILTER RESULT
                    $("#resultFilter").slideDown("slow");

                    $.each(json, function(i, item) {
                        $("#id").text(item.id);
                        $("#nome").text(item.cliente);
                        $("#total").text(item.valor_total);
                        $("#mktplace").text(item.marketplace);
                        $("#data").text(item.created_at);
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $("#Products").click(function() {

            NumberOrder = $("#id").text();

            $.ajax({
                url: "/getProductsOrder",
                type: "GET",
                data: {
                    n_order: NumberOrder,
                },
                beforeSend: function() {
                    $("#loaderDiv").show();
                    //$("#resultFilter").html("");
                },
                success: function(response) {
                    console.log(response);
                    $("#loaderDiv").slideUp('slow');
                    var json = $.parseJSON(response.products);

                    var index = [];
                    $.each(json, function(i, item) {

                        index[i] = "<tr><td>"+item.id+"</td><td>"+item.id_product+"</td><td>"+item.quantidade+"</td><td>R$: "+item.price+"</td></tr>";
                        // $("#id_product").text(item.id);
                        // $("#codigo_product").text(item.id_product);
                        // $("#quantity_product").text(item.quantidade);
                        // $("#price_product").text(item.price);
                    });
                    
                    var arr = jQuery.makeArray(index);
                    arr.reverse();
                    $("#rows").html(arr);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>
