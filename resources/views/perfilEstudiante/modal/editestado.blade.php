<div class="modal fade" id="modal_crear_estado">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title pull-center" style="justify-content: center">
          <strong>CAMBIAR ESTADO</strong> 
          </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div id="msj-error-edit" class="alert alert-danger alert-dismissible" role="alert" style="display:none">
        <strong id="msj"></strong>
      </div>  
      <div class="modal-body">
      <div class="container-fluid">
        <div class="row">
          <div style="display: none;">
            {!!Form::label('id','id ')!!}
            {!!Form::text('id',$verDatosPerfil->id,['id'=>'idE','class'=>'form-control','placeholder'=>'id para enviar al update'])!!}
          </div>  
          <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
            {!!Form::select('estadoN', $estado, $verDatosPerfil->condition ? $verDatosPerfil->condition->id : null,['id'=>'estadoN','class'=>'form-control','required','placeholder'=>'Estado'])!!}  
          </div>
          <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
              {!!Form::select('CMotivo', $motivos, $motivos,['id'=>'CMotivo','class'=>'form-control','required','placeholder'=>'* Motivos'])!!}  
          </div>
          <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
              {!!Form::textarea('observation',null,['id'=>'Cobservacion', 'class'=>'form-control','placeholder'=>'* Observacion del retiro'])!!}   
          </div>
        </div>
      </div>           
      </div>
      
          <div class="modal-footer">
            <div class="container-fluid">
              <div class="row">
                <div class="col-xs-12 col-sm-6 ">
                   {!!link_to('#',$title = 'Actualizar', $attributes = ['class'=>'btn bg-danger  elevation-3 btn-block boton_update_estado'],$secure = null)!!}                        
                   {!!Form::close()!!} 
                </div>
              </div>
            </div>
          </div>
    </div>
  </div>
</div>