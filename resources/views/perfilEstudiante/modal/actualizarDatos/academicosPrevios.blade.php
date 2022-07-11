<div class="modal fade" id="modal_actualizar_datos_academicos_previos">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title pull-center" style="justify-content: center">
                <strong>ACTUALIZAR DATOS ACADEMICOS PREVIOS</strong> 
              </h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div id="msj-error-edit" class="alert alert-danger alert-dismissible" role="alert" style="display:none">
          <strong id="msj"></strong>
          </div>
          <div class="modal-body">
              <div class="container-fluid">
                {!!Form::model($verDatosPerfil,['route'=>['updatedatosacademicosprevios',$verDatosPerfil->previousacademicdata->id], 'method'=>'PUT'])!!}
                      {{csrf_field()}}
                  <div class="row">
                      <div style="display: none;">
                      {!!Form::label('id','id ')!!}
                      {!!Form::text('id',$verDatosPerfil->previousacademicdata->id,['id'=>'idap','class'=>'form-control','placeholder'=>'id para enviar al update'])!!}
                      </div>  
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('institution_name','Nombre institucion: ')!!}
                      {!!Form::text('colegio', $verDatosPerfil->previousacademicdata ? $verDatosPerfil->previousacademicdata->institution_name : null,['id'=>'colegio','class'=>'form-control','required','placeholder'=>'Colegio'])!!}  
                      </div>
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('year_graduation','Año de graduacion: ')!!}
                      {!!Form::text('graduacion', $verDatosPerfil->previousacademicdata ? $verDatosPerfil->previousacademicdata->year_graduation : null,['id'=>'graduacion','class'=>'form-control','required','placeholder'=>'Año graduacion'])!!}  
                      </div>
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('bachelor_title','Titulo bachiller: ')!!}
                      {!!Form::text('bachiller',$verDatosPerfil->previousacademicdata ? $verDatosPerfil->previousacademicdata->bachelor_title : null,['id'=>'bachiller', 'class'=>'form-control','placeholder'=>'Titulo bachiller'])!!}   
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('url_academic_support','Soporte academico: ')!!}
                      {!!Form::text('url_academic_support',$verDatosPerfil->previousacademicdata ? $verDatosPerfil->previousacademicdata->url_academic_support : null,['id'=>'soporteAcademico', 'class'=>'form-control','placeholder'=>'Soporte academico'])!!}   
                      </div>
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('icfes_date','Fecha icfes')!!}
                      {!!Form::date('fechaIcfes',$verDatosPerfil->previousacademicdata ? $verDatosPerfil->previousacademicdata->icfes_date : null,['id'=>'fechaIcfes','class'=>'form-control','placeholder'=>'Fecha icfes'])!!}
                      </div>  
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('snp_register','Registro SNP: ')!!}
                      {!!Form::text('snpRegistro', $verDatosPerfil->previousacademicdata ? $verDatosPerfil->previousacademicdata->snp_register : null,['id'=>'snpRegistro','class'=>'form-control','required','placeholder'=>'Registro SNP'])!!}  
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12 col-sm-4 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                      {!!Form::label('icfes_score','Puntaje ICFES: ')!!}
                      {!!Form::text('icfesPuntaje', $verDatosPerfil->previousacademicdata ? $verDatosPerfil->previousacademicdata->icfes_score : null,['id'=>'icfesPuntaje','class'=>'form-control','required','placeholder'=>'Puntaje icfes'])!!}  
                      </div>
                    </div>
                  </div>
              </div>

              <div class="modal-footer">
                  <div class="container-fluid">
                      <div class="row">
                          <div class="col-xs-12 col-sm-6 ">
                                  {!!Form::submit('Guardar Datos',['class'=>'btn btn-primary btn-block boton_update_datos_academicos_previos'])!!}                       
                              {!!Form::close()!!} 
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
</div>
