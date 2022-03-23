<div class="modal" data-refresh="true"  tabindex="-1" id="modal_asistencias">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 style="text-align:center;font-size : 30px;font-weight: bolder;">{{$verDatosPerfil->name.' '.$verDatosPerfil->lastname}}</h4>
        <div class="table-responsive">
        {{--<div id="carga2" class="d-flex justify-content-center">
                        <strong>Procesando&nbsp;</strong>
                        <div class="spinner-border spinner-border-sm" role="status">                    
                        </div>
              </div> --}}
        <table id="example2" class="table table-bordered table-striped">
          <caption id="mensaje" style="caption-side: top;text-align:center;"></caption>
          <thead>
            <td>Sesion</td>
            <td>Asistio</td>
          </thead>
          <tbody id="sesiones">
          </tbody>
        </table>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@push('scripts')
<script type="text/javascript">
  

/*$("#example2").DataTable({
                        "processing": true,
                        "LoadingRecords":true,
                        "paging": true,
                        "deferRender": true,
                        "lengthChange": false,
                        "searching": true,
                        "ordering": false,
                        "info": true,
                        "autoWidth": false,
                        "responsive": true,
                        "language": {
                                "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                        },
                        "dom": 'Bfrtip',
                        "buttons": ["copy","excel", "pdf", "print"]
                });*/
</script>
@endpush

                        