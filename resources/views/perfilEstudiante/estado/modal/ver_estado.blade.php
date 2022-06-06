<div class="modal fade" id="ver_estado">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title pull-center" style="justify-content: center">
          <strong>DETALLES ESTADO</strong> 
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
            {!!Form::text('id',null,['id'=>'idV','class'=>'form-control','placeholder'=>'id para enviar al update'])!!}
          </div>  
          <div class="col-xs-12 col-sm-6 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
            {!!Form::select('estado', $estado, null,['id'=>'estadoV','class'=>'form-control','required','placeholder'=>'Estado','readonly','disabled'])!!}  
          </div>
          <div class="col-xs-12 col-sm-6 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
              {!!Form::date('Fecha',null,['id'=>'Vfecha','class'=>'form-control','required','placeholder'=>'* Motivos','readonly','disabled'])!!}  
          </div> 
          <div class="col-xs-12 col-sm-6 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
              {!!Form::select('Motivo', $motivos, null,['id'=>'VMotivo','class'=>'form-control','required','placeholder'=>'* Motivos','readonly','disabled'])!!}  
          </div>       
          <div id="urlRetiro" class="col-xs-12 col-sm-6 form-group {{$errors->has('body') ? 'has-errors' : ''}}">    
              {!!Form::text('url',null,['id'=>'VUrl','class'=>'form-control','placeholder'=>'*URL','readonly'])!!}
              <a href="" target="blank" class="fa fa-external-link" id="VBoton">Enlace Documento</a>
          </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
              {!!Form::textarea('observation',null,['id'=>'Vobservacion', 'class'=>'form-control','placeholder'=>'* Observacion','readonly'])!!}   
            </div>  
        </div>  
      </div>               
    </div>
           
      <div class="container-fluid h-100"> 
        <div class="row w-100 align-items-center">
          <div class="col-sm-3"></div>
          <div class="col col-sm-6 text-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>                    
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
