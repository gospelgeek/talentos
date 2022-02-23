<!-- MODAl PARA EDITAR-->
<div class="modal fade" id="modal_ver">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title pull-center" style="justify-content: center">
          <strong>VER SEGUIMIENTO</strong> 
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>                
      </div>
      <div id="msj-error-edit" class="alert alert-danger alert-dismissible" role="alert" style="display:none">
        <strong id="msj"></strong>
      </div>  
              
      <div class="modal-body">
        <div class="container-fluid">
        
          <div class="row">
            <div style="display: none;">
              {!!Form::label('id','id ')!!}
              {!!Form::text('id',$verDatosPerfil->socioeducationalfollowup ? $verDatosPerfil->socioeducationalfollowup->id : null,['id'=>'idSe','class'=>'form-control','placeholder'=>'id para enviar al update'])!!}   
            </div> 
            <div class= "col-xs-12 col-sm-3">
              {!!Form::label('date','Fecha*: ')!!}
              {!!Form::date('date',null,['id'=>'datfechaAver','class'=>'form-control','placeholder'=>'Fecha', 'readonly'])!!}
            </div>
            <div class= "col-xs-12 col-sm-3">
              {!!Form::label('lugarsegui','Lugar*: ')!!}
              {!!Form::text('lugarsegui',null,['id'=>'lugar12','class'=>'form-control','placeholder'=>'Lugar seguimiento', 'readonly'])!!}
            </div> 
            <div class= "col-xs-12 col-sm-3">
              {!!Form::label('iniciohora','Hora inicio*: ')!!}
              {!!Form::time('iniciohora',null,['id'=>'hInicioOs', 'class'=>'form-control','placeholder'=>'hora inicio', 'readonly'])!!}
            </div> 
            <div class= "col-xs-12 col-sm-3">
              {!!Form::label('finhora','Hora finalizacion*: ')!!}
              {!!Form::time('finhora',null,['id'=>'horafinNh', 'class'=>'form-control','placeholder'=>'hora finalizacion', 'readonly'])!!}
            </div>
            {!!Form::label('objetivos','Objetivos*: ')!!}
            <div class="col-xs-12 col-sm-12" size="100">
              <textarea disabled name="textareaobjetivos" id="textobjetivos" cols="105" rows="5" style="resize: both;">
              </textarea>
            </div>
          </div> 
        </div>
      
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            {!!Form::label('','INDIVIDUAL: ')!!}
              <div class="col-xs-12 col-sm-12" size="100">
                <textarea disabled name="texareaindividual" id="textindividualT" cols="100" rows="5" style="resize: both;">
                </textarea readonly>
              </div>
              <div class= "col-xs-12 col-sm-3">
              {!!Form::label('finhora','Riesgo individual*: ')!!}
              {!!Form::text('finhora',null,['id'=>'riesIndi', 'class'=>'form-control','placeholder'=>'Riesgo', 'readonly'])!!}
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            {!!Form::label('','ACADEMICO: ')!!}
              <div class="col-xs-12 col-sm-12" size="100">
                <textarea disabled name="textareaacademico" id="textacademico" cols="100" rows="5" style="resize: both;">
                </textarea>
              </div>
              <div class= "col-xs-12 col-sm-3">
                {!!Form::label('finhora','Riesgo academico*: ')!!}
                {!!Form::text('finhora',null,['id'=>'rsgAcdmcO', 'class'=>'form-control','placeholder'=>'Riesgo', 'readonly'])!!}
              </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            {!!Form::label('','FAMILIAR: ')!!}
            <div class="col-xs-12 col-sm-12" size="100">
              <textarea disabled name="textareafamil" id="textfamiliar" cols="100" rows="5" style="resize: both;">
              </textarea>
            </div>
            <div class= "col-xs-12 col-sm-3">
                {!!Form::label('finhora','Riesgo familiar*: ')!!}
                {!!Form::text('finhora',null,['id'=>'rsgFmlAr', 'class'=>'form-control','placeholder'=>'Riesgo', 'readonly'])!!}
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            {!!Form::label('','ECONOMICO: ')!!}
            <div class="col-xs-12 col-sm-12" size="100">
              <textarea disabled name="textareaecono" id="texteconomico" cols="100" rows="5" style="resize: both;">
              </textarea>
            </div>
            <div class= "col-xs-12 col-sm-3">
                {!!Form::label('finhora','Riesgo economico*: ')!!}
                {!!Form::text('finhora',null,['id'=>'rsgEcnmcO', 'class'=>'form-control','placeholder'=>'Riesgo', 'readonly'])!!}
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            {!!Form::label('','VIDA UNIVERSITARIA Y CIUDAD: ')!!}
            <div class="col-xs-12 col-sm-12" size="100">
              <textarea disabled name="textareavidauni" id="textvdaunvrstria" cols="100" rows="5" style="resize: both;">
              </textarea>
            </div>
            <div class= "col-xs-12 col-sm-3">
                {!!Form::label('finhora','Riesgo vida universitaria y ciudad*: ')!!}
                {!!Form::text('finhora',null,['id'=>'rsgvdUnyCdad', 'class'=>'form-control','placeholder'=>'Riesgo', 'readonly'])!!}
            </div>

            
            <div class="col-xs-12 col-sm-12" size="100">
              <br>{!!Form::label('','OBSERVACIONES: ')!!}
              <textarea disabled name="textareobservaciones" id="textobsrvacnes" cols="100" rows="5" style="resize: both;">
              </textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
      
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
             
          </div>
        </div>
      </div>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->