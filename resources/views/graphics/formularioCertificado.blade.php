@extends('layouts.app')

@section('captcha')
<script>
    $(document).ready(function() {
        $('#descargar').click(function() {
            grecaptcha.ready(function() {
                grecaptcha.execute('6LeQQvYgAAAAAHvwSUCVLu3MlhhprTlz7ssVbFd2', {
                    action: 'validar'
                }).then(function(token) {
                    $('#form-cert').prepend(`<input type="hidden" name="token" value="${token}">`);
                    $('#form-cert').prepend(`<input type="hidden" name="action" value="validar">`);
                    $('#form-cert').submit();
                });
            });
        })
    })


    
</script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">DESCARGA DE CERTIFICADO</div>
                <div class="card-body">
                    <form id="form-cert" action="/descarga_certificado" method="post">
                    @csrf
                        <div class="form-group row">
                            <label for="iden" class="col-md-4 col-form-label text-md-right">Nº de Identificacion</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" id="iden" name="iden">
                            </div>
                        </div>
                        <div style="text-align: center;">
                            <button id="descargar" type="button" class="btn btn-primary" >
                                DESCARGAR CERTIFICADO
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
