@extends('layouts.app')


@section('content')



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


@section('scripts')

<script>
    /*
    const iden = document.getElementById('iden')
    const mostrarB = document.getElementById('mostrar');

    function _click() {
        console.log(iden.value)    
    }

    mostrarB.addEventListener('click', () => {
        console.log("asdas")
    })*/

    /*$("#resultados").DataTable({
        /*"ajax": {
            "method": "GET",
            
        },
        "columns": [{
                data: 'name'
            },
            {
                data: 'lastname'
            },
            {
                data: 'document_number'
            },
            {
                data: 'cohorte'
            },
            {
                data: 'grupo'
            },
            {
                data: 'name_program'
            },
            {
                data: 'position'
            },
            {
                data: 'iteration'
            },
            {
                data: 'weighted_total'
            },
            {
                data: 'weighted_areas'
            },
            {
                data: 'average_grades'
            },
            {
                data: null,
                render: function(data, row, meta, type) {
                    //console.log(data);
                    mostrar = '1: ' + data.opc1 + '\n' + '2: ' + data.opc2 + '\n' + '3: ' + data.opc3 + '\n' + '4: ' + data.opc4 + '\n' + '5: ' + data.opc5
                    return mostrar
                }
            },
            {
                data: 'semestre_ingreso'
            },
        ],
        "deferRender": true,
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "order": [
            [4, 'asc']
        ],
        "dom": 'Bfrtip',
        "buttons": [
            "copy",
            "csv",
            "excel",
            "pdf",
            "print",
            "colvis"

        ]
    });*/
</script>

@endsection

@endsection
