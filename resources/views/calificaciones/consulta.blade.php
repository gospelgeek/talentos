@extends('layouts.dashboard')
@section('title', 'Resultado')
@section('content')
@include('../alerts.success')
@include('../alerts.request')


<div class="container-fluid">
    <h1 style="text-align:center;">RESULTADOS DE ADMISIÓN (Simulación)</h1>
    <div class="card">
        <div class="card-header">
            <div class="card">
                <div class="card-header">FORMULARIO DE CONSULTA</div>
                <div class="card-body">
                    <form action="/consulta" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="iden" class="col-md-4 col-form-label text-md-right">Nº DE IDENTIFICACION</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" id="iden" name="iden">
                            </div>
                        </div>
                        <div style="text-align: center;">
                            <button type="submit" class="btn btn-primary">
                                MOSTRAR RESULTADOS
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>


@push('scripts')

@endpush

@endsection
