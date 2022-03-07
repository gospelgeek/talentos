<div class="modal fade" id="modal_actualizar_datos_generales">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title pull-center" style="justify-content: center">
                <strong>ACTUALIZAR DATOS GENERALES</strong> 
              </h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div id="msj-error-edit" class="alert alert-danger alert-dismissible" role="alert" style="display:none">
          <strong id="msj"></strong>
          </div>
          <div class="modal-body">
              <div class="container-fluid">
                {!!Form::model($verDatosPerfil,['route'=>['updatedatosgenerales',$verDatosPerfil->id], 'method'=>'PUT'])!!}
                      {{csrf_field()}}
                  <div class="row">
                      <div style="display: none;">
                      {!!Form::label('id','id ')!!}
                      {!!Form::text('id',$verDatosPerfil->id,['id'=>'idG','class'=>'form-control','placeholder'=>'id para enviar al update'])!!}
                      </div>  
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('nombre1','Nombres: ')!!}
                      {!!Form::text('nombre1', $verDatosPerfil ? $verDatosPerfil->name : null,['id'=>'nombre1','class'=>'form-control','required','placeholder'=>'Nombres'])!!}  
                      </div>
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('lastname','Apellidos: ')!!}
                      {!!Form::text('lastname', $verDatosPerfil ? $verDatosPerfil->lastname : null,['id'=>'apellido','class'=>'form-control','required','placeholder'=>'Apellidos'])!!}  
                      </div>
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('birth_date','Fecha nacimiento: ')!!}
                      {!!Form::date('birth_date',$verDatosPerfil ? $verDatosPerfil->birth_date : null,['id'=>'fechaNacimiento', 'class'=>'form-control','placeholder'=>'Fecha nacimiento'])!!}   
                      </div>
                  </div>
                  <div class="row">
                     <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('id_document_type','Tipo documento: ')!!}
                      {!!Form::select('id_document_type', $tipo_documento, $verDatosPerfil->documenttype ? $verDatosPerfil->documenttype->id : null,['id'=>'tipoDocumento','class'=>'form-control','required','placeholder'=>'Tipo documento'])!!}  
                      </div>
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('document_number','Numero documento: ')!!}
                      {!!Form::text('document_number', $verDatosPerfil ? $verDatosPerfil->document_number : null,['id'=>'numeroDocumento','class'=>'form-control','required','placeholder'=>'Numero documento'])!!}  
                      </div>
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('document_expedition_date','Fecha de expedicion: ')!!}
                      {!!Form::date('document_expedition_date',$verDatosPerfil ? $verDatosPerfil->document_expedition_date : null,['id'=>'fechaExpedicion', 'class'=>'form-control','placeholder'=>'Fecha expedicion documento'])!!}   
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('birthcity','Ciudad nacimiento: ')!!}
                      {!!Form::select('birthcity',$ciudad_nacimiento, $verDatosPerfil->birthcity ? $verDatosPerfil->birthcity->id : null,['id'=>'ciudadNacimiento','class'=>'form-control','required','placeholder'=>'Ciudad nacimiento'])!!}   
                      </div>
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('email','Email: ')!!}
                      {!!Form::email('email', $verDatosPerfil ? $verDatosPerfil->email : null,['id'=>'correo','class'=>'form-control','required','placeholder'=>'Correo electronico'])!!}  
                      </div> 
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('sex','Sexo: ')!!}
                      {!!Form::select('sexo',$sexo, $verDatosPerfil ? $verDatosPerfil->sex : null,['id'=>'sexo1','class'=>'form-control','required','placeholder'=>'Seleccionar sexo'])!!}  
                      </div> 
                  </div>
                  <div class="row">
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('gender','Genero: ')!!}
                      {!!Form::select('genero',$genero, $verDatosPerfil->gender ? $verDatosPerfil->gender->id : null,['id'=>'generoE','class'=>'form-control','required','placeholder'=>'Genero'])!!}  
                      </div>
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('cellphone','Celular: ')!!}
                      {!!Form::text('cellphone', $verDatosPerfil ? $verDatosPerfil->cellphone : null,['id'=>'celular','class'=>'form-control','required','placeholder'=>'Celular'])!!}  
                      </div>
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('neighborhood','Barrio recidencia: ')!!}
                      {!!Form::select('barrio',$barrio, $verDatosPerfil->neighborhood ? $verDatosPerfil->neighborhood->id : null,['id'=>'barrioV','class'=>'form-control','required','placeholder'=>'Genero'])!!}  
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('direction','Direccion: ')!!}
                      {!!Form::text('direction', $verDatosPerfil ? $verDatosPerfil->direction : null,['id'=>'direccion12','class'=>'form-control','required','placeholder'=>'Direccion'])!!}  
                      </div>
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('phone','Numero alternativo: ')!!}
                      {!!Form::text('phone', $verDatosPerfil ? $verDatosPerfil->phone : null,['id'=>'telefono','class'=>'form-control','required','placeholder'=>'Telefono'])!!}  
                      </div>
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('student_code','Codigo estudiante: ')!!}
                      {!!Form::text('student_code', $verDatosPerfil ? $verDatosPerfil->student_code : null,['id'=>'codEstu','class'=>'form-control','required','placeholder'=>'Codigo estudiante'])!!}  
                      </div>
                  </div>
                  </div>
              </div>

              <div class="modal-footer">
                  <div class="container-fluid">
                      <div class="row">
                          <div class="col-xs-12 col-sm-6 ">
                                  {!!Form::submit('Guardar Datos',['class'=>'btn btn-primary btn-block boton_update_datos_generales'])!!}                       
                              {!!Form::close()!!} 
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
</div>


