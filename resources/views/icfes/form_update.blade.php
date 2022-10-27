<div class="modal" data-refresh="true" tabindex="-1" id="modal-update">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="_update">
        
        @csrf
        <div id="recargar" class="modal-body">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h6 id="nombreModal" style="text-align:center;font-size : 30px;font-weight: bolder;">FORMULARIO DE ACTUALIZACION DE ICFES</h6>
          <br><br>
          <div style="align-items: center;">

            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <p>Ingrese el nombre  del estudiante</p>
                  <input class="form-control" disabled required type="text" name="identificacion" id="identificacion">
                  
                </div>
                <div class="col-md-6">
                  <p>Ingrese el Puntaje total</p>
                  <input class="form-control" type="number" min="0" max="500" name="puntaje" id="puntaje">
                </div>
              </div>

              <div>
                <p>Seleccione la Prueba</p>
                <input class="form-control" type="text" name="pruebaVista"  id="pruebaVista">
                <input hidden class="form-control" type="number" name="prueba"  id="prueba">
              </div>

              <div>
                <p>Ingrese el Soporte de URL</p>
                <input class="form-control" type="text" name="url" id="url">
              </div>
            </div>
            <br>
            <div id="form_areas" class="form-group">

              <div class="row">

                <div class="col-md-6">
                  <div class="row">

                    <div class="col-md-6">
                      <p>Lectura Critica:</p>
                    </div>

                    <div class="col-md-4">
                      <input class="form-control" type="number" name="lecturaC" id="lecturaC">
                    </div>

                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="row">

                    <div class="col-md-6">
                      <p>Matematicas:</p>
                    </div>

                    <div class="col-md-4">
                      <input class="form-control" type="number" name="mate" id="mate">
                    </div>

                  </div>
                </div>


              </div>
              <br>
              <div class="row">

                <div class="col-md-6">
                  <div class="row">

                    <div class="col-md-6">
                      Ciencias Sociales:
                    </div>

                    <div class="col-md-4">
                      <input class="form-control" type="number" name="cienS" id="cienS">
                    </div>

                  </div>
                </div>

                <div class="col-md-6">
                  <div class="row">

                    <div class="col-md-6">
                      Ciencias Naturales:
                    </div>

                    <div class="col-md-4">
                      <input class="form-control" type="number" name="cienN" id="cienN">
                    </div>

                  </div>

                </div>

              </div>
              <br>
              <div class="row">

                <div class="col-md-6">
                  <div class="row">

                    <div class="col-md-6">
                      Ingles:
                    </div>

                    <div class="col-md-4">
                      <input  class="form-control" type="number" name="ingles" id="ingles">
                    </div>


                  </div>
                </div>

              </div>

            </div>

          </div>
        </div>
        
        <div class="modal-footer">
          <button id="_actualizar" class="btn btn-primary" data-dismiss="modal">ACTUALIZAR</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
        </div>
        </form>
    </div>
  </div>
</div>