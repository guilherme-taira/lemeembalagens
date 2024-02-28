@extends('layouts.layout')
@section('conteudo')
<div class="container mt-4">
    <form class="was-validated row g-3" action="{{route('multiloja.update',['id' => $loja->id])}}" method="POST">
        @csrf
        @method('put')
        <div class="col-md-6">
            <label for="validationServer01" class="form-label">Nome: </label>
            <input type="text" class="form-control is-valid" id="validationServer01" name="nome" value="{{$loja->name}}"  required>
            <div class="valid-feedback">
              Preencha Por Favor
            </div>
          </div>
          <div class="col-md-4">
            <label for="validationServer01" class="form-label">Código MultiLoja</label>
            <input type="text" class="form-control is-valid" id="validationServer01" name="loja" value="{{$loja->idmultiloja}}" required>
            <div class="valid-feedback">
             Preencha Por Favor
            </div>
          </div>
        <hr>
        <div class="mb-3">
          <button class="btn btn-primary" type="submit">Salvar</button>
        </div>
      </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.theme.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
    </div>
@stop
