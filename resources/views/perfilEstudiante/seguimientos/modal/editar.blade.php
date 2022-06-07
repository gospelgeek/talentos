<!-- MODAl PARA EDITAR-->
<div class="modal fade" id="modal_editar">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title pull-center" style="justify-content: center">
          <strong>EDITAR SEGUIMIENTO</strong> 
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
              {!!Form::text('id',null,['id'=>'idSeguI','class'=>'form-control','placeholder'=>'id para enviar al update'])!!}   
            </div> 
            <div class= "col-xs-12 col-sm-3">
              {!!Form::label('date','Fecha*: ')!!}
              {!!Form::date('date',null,['id'=>'datfecha','class'=>'form-control','placeholder'=>'Fecha'])!!}
            </div>
            <div class= "col-xs-12 col-sm-3">
              {!!Form::label('lugarsegui','Lugar*: ')!!}
              {!!Form::text('lugarsegui',null,['id'=>'lugar1','class'=>'form-control','placeholder'=>'Lugar seguimiento'])!!}
            </div> 
            <div class= "col-xs-12 col-sm-3">
              {!!Form::label('iniciohora','Hora inicio*: ')!!}
              {!!Form::time('iniciohora',null,['id'=>'hInicio', 'class'=>'form-control','placeholder'=>'hora inicio'])!!}
            </div> 
            <div class= "col-xs-12 col-sm-3">
              {!!Form::label('finhora','Hora finalizacion*: ')!!}
              {!!Form::time('finhora',null,['id'=>'horafin', 'class'=>'form-control','placeholder'=>'hora finalizacion'])!!}
            </div>
            <hr>
            <div class= "col-xs-12 col-sm-12">
              {!!Form::label('url_document','URL documento: ')!!}
              {!!Form::text('url_document',null,['id'=>'dcmntOUrl','class'=>'form-control','placeholder'=>'URL'])!!}
            </div>
            <hr>
            {!!Form::label('objetivos','Objetivos*: ')!!}
            <div class="col-xs-12 col-sm-12" size="100">
              <textarea name="textareaobjetivos" id="textobjetivos" cols="105" rows="5" style="resize: both;">
              </textarea>
            </div>
          </div> 
        </div>
      
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            {!!Form::label('','INDIVIDUAL: ')!!}
              <div class="col-xs-12 col-sm-12" size="100">
                <textarea name="texareaindividual" id="textindividualT" cols="100" rows="5" style="resize: both;">
                </textarea>
              </div>
              <div class= "col-xs-12 col-sm-6">
                {!!Form::label('','RIESGOS: ')!!}<br>
                  <label for="huey">Alto</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="mucho" name="checkindi" value="alto">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <label for="huey">Medio</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="mucho" name="checkindi" value="medio">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <label for="huey">Bajo</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="mucho" name="checkindi" value="bajo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  {!!link_to('#',$title = 'Limpiar', $attributes = ['class'=>'btn bg-primary  elevation-3  boton_limpiarIU'],$secure = null)!!}                        
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
                <textarea name="textareaacademico" id="textacademico" cols="100" rows="5" style="resize: both;">
                </textarea>
              </div>
              <div class= "col-xs-12 col-sm-6">
                {!!Form::label('','RIESGOS: ')!!}<br>
                  <label for="huey">Alto</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkacad" value="alto">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <label for="huey">Medio</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkacad" value="medio">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <label for="huey">Bajo</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkacad" value="bajo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  {!!link_to('#',$title = 'Limpiar', $attributes = ['class'=>'btn bg-primary  elevation-3  boton_limpiarAU'],$secure = null)!!}                        
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
              <textarea name="textareafamil" id="textfamiliar" cols="100" rows="5" style="resize: both;">
              </textarea>
            </div>
            <div class= "col-xs-12 col-sm-6">
              {!!Form::label('','RIESGOS: ')!!}<br>
                <label for="huey">Alto</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkfami" value="alto">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="huey">Medio</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkfami" value="medio">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="huey">Bajo</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkfami" value="bajo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                {!!link_to('#',$title = 'Limpiar', $attributes = ['class'=>'btn bg-primary  elevation-3  boton_limpiarFU'],$secure = null)!!}                        
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
              <textarea name="textareaecono" id="texteconomico" cols="100" rows="5" style="resize: both;">
              </textarea>
            </div>
            <div class= "col-xs-12 col-sm-6">
              {!!Form::label('','RIESGOS: ')!!}<br>
                <label for="huey">Alto</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkecono" value="alto">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="huey">Medio</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkecono" value="medio">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="huey">Bajo</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkecono" value="bajo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                {!!link_to('#',$title = 'Limpiar', $attributes = ['class'=>'btn bg-primary  elevation-3  boton_limpiarEU'],$secure = null)!!}                        
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
              <textarea name="textareavidauni" id="textvdaunvrstria" cols="100" rows="5" style="resize: both;">
              </textarea>
            </div>
            <div class= "col-xs-12 col-sm-6">
              {!!Form::label('','RIESGOS: ')!!}<br>
                <label for="huey">Alto</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkuni" value="alto">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="huey">Medio</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkuni" value="medio">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="huey">Bajo</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="huey" name="checkuni" value="bajo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                {!!link_to('#',$title = 'Limpiar', $attributes = ['class'=>'btn bg-primary  elevation-3  boton_limpiarVU'],$secure = null)!!}                        
                  {!!Form::close()!!}
            </div>
            <div class="col-xs-12 col-sm-12" size="100">
              <br>{!!Form::label('','OBSERVACIONES: ')!!}
              <textarea name="textareobservaciones" id="textobsrvacnes" cols="100" rows="5" style="resize: both;">
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
              {!!link_to('#',$title = 'Actualizar', $attributes = ['class'=>'btn bg-primary  elevation-3 btn-block boton_update_seguimiento'],$secure = null)!!}                        
              {!!Form::close()!!}                     
            </div> 
            <div class="col-xs-12 col-md-6">
              <a class="btn stylish-color text-white btn-block " data-dismiss="modal">CANCELAR</a>                         
            </div> 
          </div>
        </div>
      </div>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
