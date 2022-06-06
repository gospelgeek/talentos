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
        <div class="row col-xs-8 col-sm-8" style="float: left;">
          <div style="display: none;">
            {!!Form::label('id','id ')!!}
            {!!Form::text('id',$verDatosPerfil->id,['id'=>'idE','class'=>'form-control','placeholder'=>'id para enviar al update'])!!}
          </div>  
          <div class="col-xs-12 col-sm-6 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
            {!!Form::select('estado', $estado, $verDatosPerfil->id_state,['id'=>'estadoN','class'=>'form-control','required','placeholder'=>'Estado'])!!}  
          </div>
          <div class="col-xs-12 col-sm-6 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
              {!!Form::date('Fecha',$verDatosPerfil->withdrawals ? $verDatosPerfil->withdrawals->fecha : null,['id'=>'Cfecha','class'=>'form-control','required','placeholder'=>'* Fecha'])!!}
          </div> 
          <div class="col-xs-12 col-sm-6 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
              {!!Form::select('Motivo', $motivos, $verDatosPerfil->withdrawals ? $verDatosPerfil->withdrawals->id_reasons : null,['id'=>'CMotivo','class'=>'form-control','required','placeholder'=>'* Motivos'])!!}  
          </div>       
          <div class="col-xs-12 col-sm-6 form-group {{$errors->has('body') ? 'has-errors' : ''}}">    
              {!!Form::text('url',$verDatosPerfil->withdrawals ? $verDatosPerfil->withdrawals->url : null,['id'=>'CUrl','class'=>'form-control','placeholder'=>'*URL'])!!}
              <a href="" target="blank" class="fa fa-external-link" id="CBoton">Enlace Documento</a>
          </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
              {!!Form::textarea('observation',$verDatosPerfil->withdrawals ? $verDatosPerfil->withdrawals->observation :null,['id'=>'Cobservacion', 'class'=>'form-control','placeholder'=>'* Observacion'])!!}   
            </div>  
        </div>  
      </div>               
    </div>
           
      <div class="container-fluid h-100"> 
        <div class="row w-100 align-items-center">
          <div class="col-sm-3"></div>
          <div class="col col-sm-6 text-center">
            {!!link_to('#',$title = 'Actualizar', $attributes = ['class'=>'btn bg-danger btn-block boton_update_estado'],$secure = null)!!}                        
            {!!Form::close()!!} 
          </div>
          <div class="col-sm-3"></div>  
        </div>
      </div>
      <br>
    </div>

    </div>
  </div>
</div>
