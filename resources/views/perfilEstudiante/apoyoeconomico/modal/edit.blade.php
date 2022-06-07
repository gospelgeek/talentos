<!-- MODAl PARA CREAR-->
<div class="modal fade" id="modal_editar_apoyo_economico">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title pull-center" style="justify-content: center"><strong>EDITAR REGISTRO</strong> </h4>                
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
                      {!!Form::text('id',null,['id'=>'idapyoEcnmco','class'=>'form-control','placeholder'=>'id para enviar al update'])!!}
                    </div>
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 form-group {{$errors->has('body') ? 'has-errors' : ''}}">{!!Form::label('date','Fecha:')!!}
                          {!!Form::date('date',null,['id'=>'fchaApyo','class'=>'form-control','placeholder'=>'Fecha'])!!} 
                        </div>
                        <div class="col-xs-12 col-sm-12 form-group {{$errors->has('body') ? 'has-errors' : ''}}">{!!Form::label('url_banco','URL Banco: ')!!}
                          {!!Form::text('url_banco',null,['id'=>'urlbnco','class'=>'form-control','placeholder'=>'Banco'])!!}
                        </div>
                        <div class="col-xs-12 col-sm-12 form-group {{$errors->has('body') ? 'has-errors' : ''}}">{!!Form::label('monto','Monto: ')!!}
                          {!!Form::number('monto',null,['id'=>'mnto','class'=>'form-control','placeholder'=>'Monto'])!!}
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
                        
                        {!!link_to('#',$title = 'ACTUALIZAR', $attributes = ['class'=>'btn bg-primary   btn-block actualizar_apoyo_economico'],$secure = null)!!}                        
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
