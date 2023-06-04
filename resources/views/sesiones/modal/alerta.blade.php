<div class="modal fade" id="modal_alerta_sesion" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-md">
      <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title pull-center" style="justify-content: center">
          <strong>MENSAJE DE ALERTA</strong> 
          </h5>
        
      </div>
      <div id="msj-error-edit" class="alert alert-danger alert-dismissible" role="alert" style="display:none">
        <strong id="msj"></strong>
      </div>  
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
          
            <span id="dtos">
             ¿Está seguro que desea eliminar la sesion del &nbsp;<b id="fecha_sesion"></b>?
            </span>    
          </div>           
        </div>
      
          <div class="modal-footer">
            <div class="container-fluid">
              <div class="row">
                <div class="col-xs-6 col-sm-6">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <a id="id_sesion" class="btn bg-primary" style="width:47.2px;" onclick="boton_delete_registro_sesion(this)">SI</a> 
                </div>
                <div class="col-xs-6 col-sm-6 ">
                  {!!link_to('#',$title = 'NO', $attributes = ['class'=>'btn bg-danger  elevation-3 cerrar_modal_sesion'],$secure = null)!!}                        
                  {!!Form::close()!!}
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
