<!-- MODAl PARA CREAR-->
<div class="modal fade" id="modal_editar_sesion">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title pull-center" style="justify-content: center"><strong>EDITAR SESIÓN</strong> </h4>                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">                 
                 <span aria-hidden="true">&times;</span></button>                             
              </div>
              <div id="msj-error" class="alert alert-danger alert-dismissible" role="alert" style="display:none">
                <strong id="msj"></strong>
              </div> 
              
                <div class="modal-body">
                  <div class="container-fluid">
                    <div style="display: none;">
                      {!!Form::label('id','id ')!!}
                      {!!Form::text('id',null,['id'=>'idsesion','class'=>'form-control','placeholder'=>'id para enviar al update'])!!}
                    </div>
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('cohorte','Linea: *')!!}
                          {!!Form::select('cohorte', $cohorte, null,['id'=>'cohorT_e','class'=>'form-control','required', 'placeholder'=>'Seleccione una opción'])!!} 
                        </div>
                        <div class="col-xs-12 col-sm-12 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('id_course','Asignatura: *')!!}
                          {!!Form::select('id_course', $asignaturas, null,['id'=>'asigto_Sesion','class'=>'form-control','required','placeholder'=>'Pendiente'])!!}
                        </div>
                        <div class="col-xs-12 col-sm-12 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('id_group','Grupo: *')!!}
                          {!!Form::select('id_group', $grupos, null,['id'=>'grupoto_Sesion','class'=>'form-control','required','placeholder'=>'Pendiente'])!!}
                        </div>
                        <div class="col-xs-12 col-sm-12 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('date_session','Fecha: *')!!}
                          {!!Form::date('date_session',null,['id'=>'dateSesion','class'=>'form-control','placeholder'=>'Fecha'])!!} 
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              <div class="modal-footer">
                <div class="container-fluid">
                  <div class="row-justify-center"> 
                    <div class="row"> 
                      <div class="col-xs-12 col-md-6 form-group">                                          
                        
                        {!!link_to('#',$title = 'ACTUALIZAR', $attributes = ['class'=>'btn bg-primary   btn-block actualizar_registro_sesion'],$secure = null)!!}                        
                        {!!Form::close()!!}
                                     
                      </div>
                      
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
