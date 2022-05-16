<!-- MODAl PARA CREAR-->
<div class="modal fade" id="modal_crear_estudiante">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title pull-center" style="justify-content: center"><strong>CREAR NUEVO ESTUDIANTE</strong> </h4>                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">                 
                 <span aria-hidden="true">&times;</span></button>                             
              </div>
              <div id="msj-error" class="alert alert-danger alert-dismissible" role="alert" style="display:none">
                <strong id="msj"></strong>
              </div> 
              
                <div class="modal-body">
                  <div class="container-fluid">
                    {!!Form::open(['route'=>'create_student', 'method'=>'POST', 'id' => 'form-almacenar-estudiante'])!!}
                    {{csrf_field()}}
                    <div class="container-fluid">
                      <div class="row"> 
                        <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('name','Nombres: *')!!}
                          {!!Form::text('name',null,['id'=>'nombres1','class'=>'form-control','required','placeholder'=>'Nombres'])!!}  
                        </div>
                        <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('lastname','Apellidos: *')!!}
                          {!!Form::text('lastname',null,['id'=>'apellidos1','class'=>'form-control','required','placeholder'=>'Apellidos'])!!}  
                        </div>  
                        
                        <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('id_document_type','Selecionar tipo documento: *')!!}
                          {!!Form::select('id_document_type',$tipo_documento, null,['id'=>'documenttype','class'=>'form-control','required','placeholder'=>'Seleccionar tipo documento'])!!}  
                        </div> 
                      </div>

                      <div class="row">
                        <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('document_number','Número documento: *')!!}
                          {!!Form::number('document_number',null,['id'=>'document_number','class'=>'form-control','required','placeholder'=>'Numero documento'])!!}  
                        </div>
                        <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('birth_date','Fecha nacimiento: ')!!}
                          {!!Form::date('birth_date',null,['id'=>'fecha_nac','class'=>'form-control','required','placeholder'=>'Fecha nacimiento'])!!}  
                        </div>
                        <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('id_birth_department','Departamento nacimiento: ')!!}
                          {!!Form::select('id_birth_department',$depNacimiento, null,['id'=>'depNacimiento','class'=>'form-control','required','placeholder'=>'Departameno nacimiento'])!!}  
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('id_birth_city','Ciudad nacimiento: ')!!}
                          {!!Form::select('id_birth_city',$muni_nacimiento, null,['id'=>'muni_nacimiento','class'=>'form-control','required','placeholder'=>'Seleccionar ciudad' ,'style'=>' '])!!}
                        </div>
                        <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('email','Email: *')!!}
                          {!!Form::email('email',null,['id'=>'correo','class'=>'form-control','required','placeholder'=>'Correo elctronico'])!!}  
                        </div>
                        <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('sex','Sexo: *')!!}
                          {!!Form::select('sex', $sexo, null,['id'=>'sex','class'=>'form-control','required','placeholder'=>'Seleccionar sexo' ,'style'=>' '])!!}
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('id_gender','Género: ')!!}
                          {!!Form::select('id_gender', $genero,null,['id'=>'gener','placeholder'=>'Género','class'=>'form-control','required'])!!}
                        </div>
                        <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('id_commune','Comuna: ')!!}
                          {!!Form::select('id_commune',$comunas, null,['id'=>'comunaResidencia','class'=>'form-control','required','placeholder'=>'Seleccionar Comuna' ,'style'=>' '])!!}
                        </div>
                        <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('id_neighborhood','Barrio: ')!!}
                          {!!Form::select('id_neighborhood',$barrios, null,['id'=>'barrioResidencia','class'=>'form-control','required','placeholder'=>'Seleccionar Barrio' ,'style'=>' '])!!}
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('direction','Dirección: ')!!}
                          {!!Form::text('direction',null,['id'=>'direCcion','class'=>'form-control','required','placeholder'=>'Direccion de residencia'])!!}
                        </div>
                        <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('id_tutor','Tutor: ')!!}
                          {!!Form::select('id_tutor',$tutor,null,['id'=>'tutoR','class'=>'form-control','required','placeholder'=>'Tutor'])!!}
                        </div>
                        <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('student_code','Código estudiante: ')!!}
                          {!!Form::text('student_code',null,['id'=>'codStu','class'=>'form-control','required','placeholder'=>'Codigo estudiante'])!!}
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('linea','Cohorte: *')!!}
                          {!!Form::select('linea', $cohorte, null,['id'=>'lineaC','class'=>'form-control','required','placeholder'=>'Seleccionar Cohorte' ,'style'=>' '])!!}
                        </div>
                        <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('id_group','Grupo: *')!!}
                          {!!Form::select('id_group', $grupo, null,['id'=>'groupC','class'=>'form-control','required','placeholder'=>'Seleccionar Grupo' ,'style'=>' '])!!}
                        </div>
                        <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('id_moodle','ID moodle: ')!!}
                          {!!Form::number('id_moodle',null,['id'=>'mooDle','class'=>'form-control','required','placeholder'=>'Moodle'])!!}
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('cellphone','Numero telefónico: ')!!}
                          {!!Form::number('cellphone',null,['id'=>'celular','class'=>'form-control','required','placeholder'=>'Numero telefónico'])!!}
                        </div>
                        <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                          {!!Form::label('phone','Numero telefónico alternativo: ')!!}
                          {!!Form::number('phone',null,['id'=>'telefono','class'=>'form-control','required','placeholder'=>'Numero alternativo'])!!}
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
                        {!!link_to('#',$title = 'REGISTRAR', $attributes = ['class'=>'btn bg-primary   btn-block boton_almacenar_estudiante'],$secure = null)!!}                        
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
