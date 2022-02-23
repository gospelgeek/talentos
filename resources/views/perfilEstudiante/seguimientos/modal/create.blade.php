<div class="modal fade" id="modal_crear_datos_seguimiento_socioeducativo">
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
          {!!Form::open(['route'=>'crearseguimiento',$verDatosPerfil->id, 'method'=>'POST', 'id' => 'form-almacenar', 'enctype'=>'multipart/form-data'])!!}
              {{csrf_field()}}
          <div class="row">
            <div style="display: none;">
              {!!Form::label('id_student','id ')!!}
              {!!Form::text('id_student',$verDatosPerfil->id,['id'=>'idsSd','class'=>'form-control','placeholder'=>'id para enviar al update'])!!}   
            </div> 
            <div class= "col-xs-12 col-sm-3">
              {!!Form::label('date','Fecha*: ')!!}
              {!!Form::date('date',null,['id'=>'datfechA','class'=>'form-control','placeholder'=>'Fecha'])!!}
            </div>
            <div class= "col-xs-12 col-sm-3">
              {!!Form::label('lugarsegui','Lugar*: ')!!}
              {!!Form::text('lugarsegui',null,['id'=>'lugar','class'=>'form-control','placeholder'=>'Lugar seguimiento'])!!}
            </div> 
            <div class= "col-xs-12 col-sm-3">
              {!!Form::label('iniciohora','Hora inicio*: ')!!}
              {!!Form::time('',null,['id'=>'hInicioo', 'class'=>'form-control','placeholder'=>'hora inicio'])!!}
            </div> 
            <div class= "col-xs-12 col-sm-3">
              {!!Form::label('finhora','Hora finalizacion*: ')!!}
              {!!Form::time('',null,['id'=>'horafinn', 'class'=>'form-control','placeholder'=>'hora finalizacion'])!!}
            </div>
            <br>{!!Form::label('objetivos','Objetivos*: ')!!}
            <div class="col-xs-12 col-sm-12" size="100">
              <textarea name="textareaobjetivos" id="objetivos" cols="109" rows="5" style="resize: both;">
              </textarea>
            </div>
          </div> 
        </div>
      
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            {!!Form::label('','INDIVIDUAL: ')!!}
              <div class="col-xs-12 col-sm-12" size="100">
                <textarea name="texareaindividual" id="individualT" cols="100" rows="5" style="resize: both;">
                </textarea>
              </div>
              <div class= "col-xs-12 col-sm-6">
                {!!Form::label('','RIESGOS: ')!!}<br>
                  <label for="huey">Alto</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="mucho" name="checkindiV" value="alto">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <label for="huey">Medio</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="mucho" name="checkindiV" value="medio">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <label for="huey">Bajo</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="mucho" name="checkindiV" value="bajo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  {!!link_to('#',$title = 'Limpiar', $attributes = ['class'=>'btn bg-primary  elevation-3  boton_limpiarI'],$secure = null)!!}                        
                  {!!Form::close()!!}
              </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            {!!Form::label('','ACADEMICO: ')!!}
              <div class="col-xs-12 col-sm-12" size="100">
                <textarea name="textareaacademico" id="academico" cols="100" rows="5" style="resize: both;">
                </textarea>
              </div>
              <div class= "col-xs-12 col-sm-6">
                {!!Form::label('','RIESGOS: ')!!}<br>
                  <label for="huey">Alto</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkacadE" value="alto">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <label for="huey">Medio</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkacadE" value="medio">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <label for="huey">Bajo</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkacadE" value="bajo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  {!!link_to('#',$title = 'Limpiar', $attributes = ['class'=>'btn bg-primary  elevation-3  boton_limpiarA'],$secure = null)!!}                        
                  {!!Form::close()!!}
              </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            {!!Form::label('','FAMILIAR: ')!!}
            <div class="col-xs-12 col-sm-12" size="100">
              <textarea name="textareafamil" id="familiar" cols="100" rows="5" style="resize: both;">
              </textarea>
            </div>
            <div class= "col-xs-12 col-sm-6">
              {!!Form::label('','RIESGOS: ')!!}<br>
                <label for="huey">Alto</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkfamiL" value="alto">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="huey">Medio</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkfamiL" value="medio">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="huey">Bajo</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkfamiL" value="bajo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                {!!link_to('#',$title = 'Limpiar', $attributes = ['class'=>'btn bg-primary  elevation-3  boton_limpiarF'],$secure = null)!!}                        
                {!!Form::close()!!}
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            {!!Form::label('','ECONOMICO: ')!!}
            <div class="col-xs-12 col-sm-12" size="100">
              <textarea name="textareaecono" id="economico" cols="100" rows="5" style="resize: both;">
              </textarea>
            </div>
            <div class= "col-xs-12 col-sm-6">
              {!!Form::label('','RIESGOS: ')!!}<br>
                <label for="huey">Alto</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkeconoM" value="alto">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="huey">Medio</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkeconoM" value="medio">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="huey">Bajo</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkeconoM" value="bajo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                {!!link_to('#',$title = 'Limpiar', $attributes = ['class'=>'btn bg-primary  elevation-3  boton_limpiarE'],$secure = null)!!}                        
                {!!Form::close()!!}
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            {!!Form::label('','VIDA UNIVERSITARIA Y CIUDAD: ')!!}
            <div class="col-xs-12 col-sm-12" size="100">
              <textarea name="textareavidauni" id="vdaunvrstria" cols="100" rows="5" style="resize: both;">
              </textarea>
            </div>
            <div class= "col-xs-12 col-sm-6">
              
              {!!Form::label('','RIESGOS: ')!!}<br>
                <label for="huey">Alto</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkuniC" value="alto" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="huey">Medio</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkuniC" value="medio">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="huey">Bajo</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkuniC" value="bajo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                {!!link_to('#',$title = 'Limpiar', $attributes = ['class'=>'btn bg-primary  elevation-3  boton_limpiarV'],$secure = null)!!}                        
                {!!Form::close()!!} 
            </div>
            
            <div class="col-xs-12 col-sm-12" size="100">
              <br>{!!Form::label('','OBSERVACIONES: ')!!}
              <textarea name="textareobservaciones" id="obsrvacnes" cols="100" rows="5" style="resize: both;">
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
                   {!!link_to('#',$title = 'Crear seguimiento', $attributes = ['class'=>'btn bg-primary  elevation-3 btn-block boton_almacenar_seguimiento'],$secure = null)!!}                        
                   {!!Form::close()!!} 
              </div>
            </div>
          </div>
      </div>       
    </div>      
  </div>       
</div>

  