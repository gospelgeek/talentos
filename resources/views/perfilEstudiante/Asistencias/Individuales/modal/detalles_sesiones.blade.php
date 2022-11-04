<div class="modal" data-refresh="true"  tabindex="-1" id="modal_sesiones">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id="nombre" style="text-align:center;font-size : 30px;font-weight: bolder;"></h4>
        <hr>
        <div  class="table-responsive">
        <table id="sesiones_tabla" class="table table-bordered table-striped">
          <caption id="mensaje" style="caption-side: top;text-align:center;"></caption>
          <thead>
            <th>Sesion</th>
            <th>Asistio</th>
          </thead>
          <tfoot>
            <th>Total Asistencias</th>
            <th></th>
          </tfoot>
        </table>
        <hr>
        <h4 id="sesiones_adicionales" style='display:none;'>ASISTENCIAS EN OTROS GRUPOS</h4>
        <table id="sesiones_tabla_2" class="table table-bordered table-striped" style='display:none'>
          <thead>
            <th>Sesion</th>
            <th>Grupo</th>
            <th>Asistio</th>
          </thead>
          <tfoot>
            <th colspan="2">Total Asistencias</th>
            <th></th>
          </tfoot>
        </table>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>         
