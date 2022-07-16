@extends('layouts.dashboard')
@section('title', 'Reporte Grupos')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="container-fluid">
    <h1 style="text-align:center;">REPORTES POR GRUPO</h1>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm">
                    Linea 1
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')

@endpush
@endsection