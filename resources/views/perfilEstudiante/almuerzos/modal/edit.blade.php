<!-- MODAl PARA CREAR-->
<div class="modal fade" id="modal_editar_almuerzo">
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
                      {!!Form::text('id',null,['id'=>'idregistro','class'=>'form-control','placeholder'=>'id para enviar al update'])!!}
                    </div>
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 form-group {{$errors->has('body') ? 'has-errors' : ''}}">{!!Form::label('date','Fecha:')!!}
                          {!!Form::date('date',null,['id'=>'fechaAlmuerzo','class'=>'form-control','placeholder'=>'Fecha'])!!} 
                        </div>
                        <div class="col-xs-12 col-sm-12 form-group {{$errors->has('body') ? 'has-errors' : ''}}">{!!Form::label('number_lunches_line1','Cantidad almuerzos Linea 1: ')!!}
                          {!!Form::number('number_lunches_line1',null,['id'=>'cantLinea1','class'=>'form-control','placeholder'=>'Cantidad almuerzos Linea 1'])!!}
                        </div>
                        <div class="col-xs-12 col-sm-12 form-group {{$errors->has('body') ? 'has-errors' : ''}}">{!!Form::label('number_lunches_line2','Cantidad almuerzos Linea 2: ')!!}
                          {!!Form::number('number_lunches_line2',null,['id'=>'cantLinea2','class'=>'form-control','placeholder'=>'Cantidad almuerzos Linea 2'])!!}
                        </div>
                        <div class="col-xs-12 col-sm-12 form-group {{$errors->has('body') ? 'has-errors' : ''}}">{!!Form::label('number_lunches_line3','Cantidad almuerzos Linea 3: ')!!}
                          {!!Form::number('number_lunches_line3',null,['id'=>'cantLinea3','class'=>'form-control','placeholder'=>'Cantidad almuerzos Linea 3'])!!}
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
                        
                        {!!link_to('#',$title = 'ACTUALIZAR', $attributes = ['class'=>'btn bg-primary   btn-block actualizar_registro_almuerzo'],$secure = null)!!}                        
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
