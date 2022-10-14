<div class="modal" data-refresh="true" tabindex="-1" id="modal-registro">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="_registro">
        @csrf
        <div id="recargar" class="modal-body">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h6 id="nombreModal" style="text-align:center;font-size : 30px;font-weight: bolder;">FORMULARIO DE REGISTRO DE ICFES</h6>
          <br><br>
          <div style="align-items: center;">

            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label for="">INGRESE LA IDENTIFICACION DEL ESTUDIANTE</label>
                  <input class="form-control" list="estudiantes" type="text" name="identificacion" id="identificacion">
                  <datalist id="estudiantes">
                    @foreach ($estudiantes as $lista)
                    <option value="{{$lista->document_number}}">{{$lista->name}} {{$lista->lastname}}</option>
                    @endforeach
                  </datalist>
                </div>
                <div class="col-md-6">
                  <label for="">INGRESE EL PUNTAJE TOTAL</label>
                  <input class="form-control" type="number" min="0" max="500" name="puntaje" id="puntaje">
                </div>
              </div>

              <div>
                <label for="">SELECCIONE LA PRUEBA </label>
                <select class="form-control" disabled>
                  <option selected value="{{$pruebas[4]->id}}">{{$pruebas[4]->name}}</option>
                  
                </select>
                <select class="form-control" name="prueba" id="prueba" hidden>
                  <option selected value="{{$pruebas[4]->id}}">{{$pruebas[4]->name}}</option>
                  
                </select>
              </div>

              <div>
                <label for="">INGRESE EL SOPORTE URL </label>
                <input class="form-control" type="text" name="url" id="url">
              </div>
            </div>

            <div class="row">
              &nbsp;
              <div class="col-ms-2 " style="padding: 0; margin: 0;">
                <label for="">REGISTRAR RESULTADO POR AREA</label>
              </div>
              &nbsp;
              &nbsp;
              <div class="col-ms-4">
                <input class="form-control mt-0" checked style="width: 20px; height: 19px;" type="checkbox" name="r_areas" id="r_areas">
              </div>
            </div>
            <br>

            <div id="form_areas" hidden class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label for="">INGRESE LA CALIFICACION DE LECTURA CRITICA</label>
                  <input class="form-control"  type="text" name="lecturaC" id="lecturaC">
                </div>
                <div class="col-md-6">
                  <label for="">INGRESE LA CALIFICACION DE MATEMATICAS</label>
                  <input class="form-control"  type="text" name="mate" id="mate">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label for="">INGRESE LA CALIFICACION DE CIENCIAS SOCIALES</label>
                  <input class="form-control"  type="text" name="cienS" id="cienS">
                </div>
                <div class="col-md-6">
                  <label for="">INGRESE LA CALIFICACION DE CIENCIAS NARUTALES</label>
                  <input class="form-control"  type="text" name="cienN" id="cienN">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label for="">INGRESE LA CALIFICACION DE INGLES</label>
                  <input class="form-control" type="text" name="ingles" id="ingles">
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button id="_guardar" class="btn btn-primary" >GUARDAR Y CONTINUAR NUEVO REGISTRO</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
        </div>
      </form>
    </div>
  </div>
</div>
