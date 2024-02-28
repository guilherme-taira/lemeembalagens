@extends('layouts.layout')
@section('conteudo')
    <div class="container space-import">
        
        @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
       @endif

       @if (session('alert'))
       <div class="alert alert-danger" role="alert">
           {{ session('alert') }}
       </div>
      @endif

        <div class="card">
            <div class="card-header">
                Importar Dados
            </div>
            <div class="card-body">
                <h5 class="card-title">Importar dados do Excel</h5>
                <form action="{{ route('import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" class="form-control" name="file" aria-label="file example" required><hr>
                    <button class="btn btn-primary" type="submit">Importar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
