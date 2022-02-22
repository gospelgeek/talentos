<div class="modal fade" id="modal_cambiar_cohorte_grupo">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title pull-center" style="justify-content: center">
          <strong>CAMBIAR COHORTE-GRUPO</strong> 
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
            {!!Form::text('id',$verDatosPerfil->studentGroup ? $verDatosPerfil->studentGroup->id : null,['id'=>'idGr','class'=>'form-control','placeholder'=>'id para enviar al update'])!!}
          </div>  
          <div class="col-xs-12 col-sm-6 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
            {!!Form::label('cohorte','Cohorte: ')!!}
            {!!Form::select('cohorte', $cohorte, $verDatosPerfil->studentGroup->group->cohort ? $verDatosPerfil->studentGroup->group->cohort->id : null,['id'=>'cohorT','class'=>'form-control','required','placeholder'=>'Cohorte'])!!}  
          </div>
          <div class="col-xs-12 col-sm-6 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
            {!!Form::label('grupo','Grupo: ')!!}
            {!!Form::select('grupo', $grupos, $verDatosPerfil->studentGroup ? $verDatosPerfil->studentGroup->group->id : null,['id'=>'grupOm','class'=>'form-control','required','placeholder'=>'Grupo'])!!} 
          </div>
          
        </div>
      </div>           
      </div>
      
          <div class="modal-footer">
            <div class="container-fluid">
              <div class="row">
                <div class="col-xs-12 col-sm-6 ">
                   {!!link_to('#',$title = 'Actualizar', $attributes = ['class'=>'btn bg-primary  elevation-3 btn-block boton_update_cohorte_grupo'],$secure = null)!!}                        
                   {!!Form::close()!!} 
                </div>
              </div>
            </div>
          </div>
    </div>
  </div>
</div>