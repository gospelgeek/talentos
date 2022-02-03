<div class="modal fade" id="modal_actualizar_datos_seguimiento_socioeducativo">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title pull-center" style="justify-content: center">
          <strong>CREAR SEGUIMIENTO SOCIOEDUCATIVO</strong> 
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
              {!!Form::open(['route'=>'crearseguimiento', 'method'=>'POST', 'id' => 'form-almacenar-seguimiento'])!!}
              {{csrf_field()}}     
            </div> 
            <div class= "col-xs-12 col-sm-3">
              {!!Form::label('','Fecha*: ')!!}
              {!!Form::date('',null,['class'=>'form-control','placeholder'=>'Fecha'])!!}
            </div>
            <div class= "col-xs-12 col-sm-3">
              {!!Form::label('','Lugar*: ')!!}
              {!!Form::text('',null,['class'=>'form-control','placeholder'=>'Lugar seguimiento'])!!}
            </div> 
            <div class= "col-xs-12 col-sm-3">
              {!!Form::label('','Hora inicio*: ')!!}
              {!!Form::time('',null,['class'=>'form-control','placeholder'=>'hora inicio'])!!}
            </div> 
            <div class= "col-xs-12 col-sm-3">
              {!!Form::label('','Hora finalizacion*: ')!!}
              {!!Form::time('',null,['class'=>'form-control','placeholder'=>'hora finalizacion'])!!}
            </div>
            {!!Form::label('','Objetivos*: ')!!}
            <div class="col-xs-12 col-sm-12" size="100">
              <textarea name="mitextarea" id="mitextarea" cols="109" rows="5" style="resize: both;">
              </textarea>
            </div>
          </div> 
        </div>
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            {!!Form::label('','INDIVIDUAL')!!}
            <div class="col-xs-12 col-sm-12" size="100">
              <textarea name="mitextarea" id="mitextarea" cols="109" rows="5" style="resize: both;">
              </textarea>
            </div>
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
  