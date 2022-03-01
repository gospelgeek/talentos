<div class="modal fade" id="modal_alerta">
  <div class="modal-dialog modal-lg">
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
          <label id="dtos">¿Esta seguro que desea cambiar el estudiante&nbsp;&nbsp;{{ $verDatosPerfil->name }}&nbsp;&nbsp;{{ $verDatosPerfil->lastname }}&nbsp;&nbsp;de su cohorte &nbsp;&nbsp;{{ $verDatosPerfil->studentGroup->group->cohort->name }}&nbsp;&nbsp;y &nbsp;&nbsp;{{ $verDatosPerfil->studentGroup->group->name }}, a la cohorte &nbsp;&nbsp;<label id="mstrchrte"></label>&nbsp;&nbsp;<label id="mstrgrpo"></label>?</label>   
        </div>           
      </div>
      
          <div class="modal-footer">
            <div class="container-fluid">
              <div class="row">
                <div class="col-xs-6 col-sm-6">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  {!!link_to('#',$title = 'SI  ', $attributes = ['class'=>'btn bg-primary  elevation-3 boton_actualizar'],$secure = null)!!}                        
                  {!!Form::close()!!} 
                </div>
                <div class="col-xs-6 col-sm-6 ">
                  {!!link_to('#',$title = 'NO', $attributes = ['class'=>'btn bg-danger  elevation-3 cerrar_modal'],$secure = null)!!}                        
                  {!!Form::close()!!}
                </div>
              </div>
            </div>
          </div>
    </div>
  </div>
</div>