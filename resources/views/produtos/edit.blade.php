@extends('layouts.layout')
@section('conteudo')
    <div class="container mt-4">
        <form class="was-validated row g-3" action="{{route('produtos.update', ['produto' => $produto->id])}}" method="POST">
            @csrf
            @method('put')
            <div class="col-md-8">
                <label for="validationServer01" class="form-label">Nome: </label>
                <input type="text" class="form-control is-valid" id="validationServer01" name="nome" value="{{$produto->nome}}" required>
                <div class="valid-feedback">
                  Preencha Por Favor
                </div>
              </div>
              <div class="col-md-1">
                <label for="validationServer01" class="form-label">Estoque</label>
                <input type="number" class="form-control is-valid" id="validationServer01" name="stock" value="{{$produto->saldo}}" required>
                <div class="valid-feedback">
                 Preencha Por Favor
                </div>
              </div>

              <div class="col-md-3">
                <label for="validationServer01" class="form-label">Secundário</label>
                <input type="text" class="form-control is-valid" id="validationServer01" name="secundario" value="{{$produto->secundario}}" required>
                <div class="valid-feedback">
                 Preencha Por Favor
                </div>
              </div>

              <div class="col-md-1">
                <label for="validationServer01" class="form-label">Desconto</label>
                <input type="text" class="form-control is-valid" id="validationServer01" name="desconto" value="{{$produto->desconto}}" required>
                <div class="valid-feedback">
                 Preencha Por Favor
                </div>
              </div>

              <div class="col-md-2">
                <label for="validationServer01" class="form-label">Valor</label>
                <input type="text" class="form-control is-valid" id="validationServer01" name="valor" value="{{$produto->valor}}" required>
                <div class="valid-feedback">
                    Preencha Por Favor
                </div>
              </div>

              <div class="col-md-2">
                <label for="validationServer01" class="form-label">Quantidade de Baixa </label>
                <input type="text" class="form-control is-valid" id="validationServer01" name="qtdbaixa" value="{{$produto->QTDBAIXA}}" required>
                <div class="valid-feedback">
                    Preencha Por Favor
                </div>
              </div>

              <div class="col-md-2">
                <label for="validationServer01" class="form-label">SKU </label>
                <input type="text" class="form-control is-valid" id="validationServer01" name="sku" value="{{$produto->sku}}" required>
                <div class="valid-feedback">
                    Preencha Por Favor
                </div>
              </div>

              <div class="col-md-2">
                <label for="validationServer01" class="form-label">Ativo</label>
                <select class="form-select" name="status" required aria-label="select example">
                  <option value="">Selecione..</option>
                  <option value="Ativo">Ativo</option>
                  <option value="Inativo">Inativo</option>
                </select>
                <div class="invalid-feedback">Selecione uma das opções!</div>
              </div>
          <hr>
          <h5>Promoção</h5>
              <div class="col-md-2">
                <label for="validationServer01" class="form-label">Data Inicial </label>
                <input type="date" class="form-control is-valid" id="validationServer01"  name="datainicial" value="{{$produto->dataInicial}}" required>
                <div class="valid-feedback">
                    Preencha Por Favor
                </div>
              </div>

              <div class="col-md-2">
                <label for="validationServer01" class="form-label">Data Final </label>
                <input type="date" class="form-control is-valid" id="validationServer01" name="datafinal" value="{{$produto->dataFinal}}" required>
                <div class="valid-feedback">
                    Preencha Por Favor
                </div>
              </div>

              <div class="col-md-2">
                <label for="validationServer01" class="form-label">Valor Promocional </label>
                <input type="text" class="form-control is-valid" id="validationServer01" name="valPromocao" value="{{$produto->valorPromocional}}" required>
                <div class="valid-feedback">
                    Preencha Por Favor
                </div>
              </div>
            <hr>
            <div class="mb-3">
              <button class="btn btn-primary" type="submit">Salvar</button>
            </div>
          </form>
    </div>
    <hr>
@stop