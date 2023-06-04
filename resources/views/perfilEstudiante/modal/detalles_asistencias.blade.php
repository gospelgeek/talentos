<div class="modal" data-backdrop="static" data-refresh="true"  data-keyboard="false" tabindex="-1" id="modal_asistencias">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div id="recargar" class="modal-body">
        <a type="button" class="close" onclick="cerrar_modal()">&times;</a>
        <h4 style="text-align:center;font-size : 30px;font-weight: bolder;">{{$verDatosPerfil->name.' '.$verDatosPerfil->lastname}}</h4>
        <div  class="table-responsive">
        <table id="sesiones_tabla" class="table table-bordered table-striped">
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
        <a type="button" class="btn btn-secondary" onclick="cerrar_modal()">Close</a>
      </div>
    </div>
  </div>
</div>
