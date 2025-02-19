@extends('layouts.dashboard')

@section('title', 'Asistencias Estudiantes')
@section('content')
@include('../alerts.success')
@include('../alerts.request')
<div class="container-fluid">    
    <h1 style="text-align:center;">REPORTE GENERAL DE ASISTENCIAS INDIVIDUALES</h1>
    <div class="card">         
        <div class="card-body">
            <div class="row">
                <div class="col-sm-2">  
                    {!!Form::select('id_cohorte', $cohorte, null,['id'=>'Ecohort','class'=>'form-control','placeholder'=>'Seleccione una Linea', 'display'=>'inline-block'])!!}
                </div>
                <div id="div_1" class="col-sm-8 asistencias_mes" style="display:none">
                    <form name="mes">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label class="radio-inline">TODOS <input type="radio" name="filtro" value="1" id="todos" ></label>&nbsp;&nbsp;&nbsp;
                        <label class="radio-inline">FEBRERO <input type="radio" name="filtro" value="2" id="febrero"></label>&nbsp;&nbsp;&nbsp;
                        <label class="radio-inline">MARZO <input type="radio" name="filtro" value="3" id="marzo"></label>&nbsp;&nbsp;&nbsp;
                        <label class="radio-inline">ABRIL <input type="radio" name="filtro" value="4" id="abril"></label>&nbsp;&nbsp;&nbsp;
                        <label class="radio-inline">MAYO  <input type="radio" name="filtro" value="5" id="mayo"></label>&nbsp;&nbsp;&nbsp;
                        <label class="radio-inline">JUNIO <input type="radio" name="filtro" value="6" id="junio"></label>&nbsp;&nbsp;&nbsp;
                        <label class="radio-inline">JULIO <input type="radio" name="filtro" value="7" id="julio"></label>&nbsp;&nbsp;&nbsp;
                        <label class="radio-inline">AGOSTO <input type="radio" name="filtro" value="8" id="agosto"></label>&nbsp;&nbsp;&nbsp;
                        <label class="radio-inline">SEPTIEMBRE <input type="radio" name="filtro" value="9" id="septiembre" checked></label>&nbsp;<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label class="radio-inline">OCTUBRE <input type="radio" name="filtro" value="10" id="octubre"></label>&nbsp;&nbsp;&nbsp;
                        <label class="radio-inline">NOVIEMBRE <input type="radio" name="filtro" value="11" id="noviembre"></label>&nbsp;&nbsp;&nbsp;
                        <label class="radio-inline" style='display:none' >ACEPTACION <input type="radio" name="filtro" value="12" id="aceptacion"  style='display:none'></label>&nbsp;
                    </form>                     
                </div>  
            </div>
            <div class="btn-group">
                <div class="filtroCohortes col-xs-6 col-md-12 col-sm-6">
                    <label>PRESENCIAL</label>&nbsp;<input type="checkbox" name="check" value="PRESENCIAl" id="presencial" checked>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>VIRTUAL</label>&nbsp;<input type="checkbox" name="check" value="VIRTUAl" id="virtual" checked>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>FECHA ACEPTACION</label>&nbsp;<input type="checkbox" name="check" value="ACEPTACION" id="aceptacion" >&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
            </div>
            <br>
            <div id="tabla_1" class="table-responsive" style='display:none'>
                <table id="example1" class="table table-striped">
                    <caption>Fecha ultima carga: {{ $carga }}</caption>
                    <thead class="table-bordered">
                        <tr >
                            <th rowspan="2">Nombres</th>
                            <th rowspan="2">Apellidos</th>
                            <th rowspan="2">Tipo Doc</th>
                            <th rowspan="2">Nº documento</th>
                            <th rowspan="2">Grupo</th>
                            @if(auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2)
                            <th rowspan="2" data-condition="{{auth()->user()->rol_id}}" id="encargado"> Profesional Encargado</th>
                            @endif
                            <th rowspan="2">Estado</th>
                            <th rowspan="2"> Fecha Aceptacion</th>
                            <th colspan="10" style="border-left: black solid 2px;">ACCION CIUDADANA</th>
                            <th colspan="10" style="border-left: black solid 2px;">ARTES</th>
                            <th colspan="10" style="border-left: black solid 2px;">BIOLOGIA</th>
                            <th colspan="10" style="border-left: black solid 2px;">CULTURA DEMOCRATICA</th>
                            <th colspan="10" style="border-left: black solid 2px;">DEPORTE</th>
                            <th colspan="10" style="border-left: black solid 2px;">DIALOGO</th>
                            <th colspan="10" style="border-left: black solid 2px;">FILOSOFIA</th>
                            <th colspan="10" style="border-left: black solid 2px;">FISICA</th>
                            <th colspan="10" style="border-left: black solid 2px;">GEOGRAFIA</th>
                            <th colspan="10" style="border-left: black solid 2px;">HISTORIA</th>
                            <th colspan="10" style="border-left: black solid 2px;">INGLES</th>
                            <th colspan="10" style="border-left: black solid 2px;">LECTURA CRITICA</th>
                            <th colspan="10" style="border-left: black solid 2px;">MATEMATICAS</th>
                            <th colspan="10" style="border-left: black solid 2px;">QUIMICA</th>
                            <th colspan="10" style="border-left: black solid 2px;">TIC</th>
                            <th colspan="9"  style="border-left: black solid 2px;">Total</th>
                            <th rowspan="2"  style="border-left: black solid 2px;">Cambio Grupo</th>
                            <th rowspan="2" id="ultima1">VER DETALLE</th>
                        </tr>
                        <tr>
                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Total Virtual</th>
                            <th>Total Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total Presencial</th>
                            <th>Total Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total Asistencias</th>
                            <th>Total Asistencias Calificadas</th>
                            <th>%</th>
                        </tr>
                    </thead> 
                </table>
            </div>
            <div id="tabla_2" class="table-responsive" style='display:none'>
                <table id="example2" class="table table-striped">
                    <caption>Fecha ultima carga: {{ $carga }}</caption>
                    <thead class="table-bordered">
                        <tr >
                            <th rowspan="2">Nombres</th>
                            <th rowspan="2">Apellidos</th>
                            <th rowspan="2">Tipo Doc</th>
                            <th rowspan="2">Nº documento</th>
                            <th rowspan="2">Grupo</th>
                            @if(auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2)
                            <th rowspan="2">Profesional Encargado</th>
                            @endif
                            <th rowspan="2">Estado</th>
                            <th rowspan="2"> Fecha Aceptacion</th>
                            <th colspan="10" style="border-left: black solid 2px;">ACCION CIUDADANA</th>
                            <th colspan="10" style="border-left: black solid 2px;">ARTES</th>
                            <th colspan="10" style="border-left: black solid 2px;">BIOLOGIA</th>
                            <th colspan="10" style="border-left: black solid 2px;">DEPORTE</th>
                            <th colspan="10" style="border-left: black solid 2px;">DIALOGO</th>
                            <th colspan="10" style="border-left: black solid 2px;">CONSTITUCION</th>
                            <th colspan="10" style="border-left: black solid 2px;">FISICA</th>
                            <th colspan="10" style="border-left: black solid 2px;">GEOGRAFIA</th>
                            <th colspan="10" style="border-left: black solid 2px;">HISTORIA</th>
                            <th colspan="10" style="border-left: black solid 2px;">INGLES</th>
                            <th colspan="10" style="border-left: black solid 2px;">LECTURA CRITICA</th>
                            <th colspan="10" style="border-left: black solid 2px;">MATEMATICAS</th>
                            <th colspan="10" style="border-left: black solid 2px;">QUIMICA</th>
                            <th colspan="10" style="border-left: black solid 2px;">TIC</th>
                            <th colspan="9"  style="border-left: black solid 2px;">Total</th>
                            <th rowspan="2"  style="border-left: black solid 2px;">Cambio Grupo</th>
                            <th rowspan="2" id="ultima2">VER DETALLES</th>
                        </tr>
                        <tr>
                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Total Virtual</th>
                            <th>Total Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total Presencial</th>
                            <th>Total Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total Asistencias</th>
                            <th>Total Asistencias Calificadas</th>
                            <th>%</th>
                        </tr>
                    </thead> 
                </table>
            </div>
            <div id="tabla_3" class="table-responsive" style='display:none'>
                <table id="example3" class="table table-striped">
                    <caption>Fecha ultima carga: {{ $carga }}</caption>
                    <thead class="table-bordered">
                        <tr >
                            <th rowspan="2">Nombres</th>
                            <th rowspan="2">Apellidos</th>
                            <th rowspan="2">Tipo Doc</th>
                            <th rowspan="2">Nº documento</th>
                            <th rowspan="2">Grupo</th>
                            @if(auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2)
                            <th rowspan="2">Profesional Encargado</th>
                            @endif
                            <th rowspan="2">Estado</th>
                            <th rowspan="2"> Fecha Aceptacion</th>
                            <th colspan="10" style="border-left: black solid 2px;">BIOLOGIA</th>
                            <th colspan="10" style="border-left: black solid 2px;">DIALOGO</th>
                            <th colspan="10" style="border-left: black solid 2px;">CONSTITUCION</th>
                            <th colspan="10" style="border-left: black solid 2px;">FISICA</th>
                            <th colspan="10" style="border-left: black solid 2px;">GEOGRAFIA</th>
                            <th colspan="10" style="border-left: black solid 2px;">HISTORIA</th>
                            <th colspan="10" style="border-left: black solid 2px;">INGLES</th>
                            <th colspan="10" style="border-left: black solid 2px;">LECTURA CRITICA</th>
                            <th colspan="10" style="border-left: black solid 2px;">MATEMATICAS</th>
                            <th colspan="10" style="border-left: black solid 2px;">PRACTICAS ARTISTICAS</th>
                            <th colspan="10" style="border-left: black solid 2px;">QUIMICA</th>
                            <th colspan="10" style="border-left: black solid 2px;">TIC</th>
                            <th colspan="9"  style="border-left: black solid 2px;">Total</th>
                            <th rowspan="2"  style="border-left: black solid 2px;">Cambio Grupo</th>
                            <th rowspan="2" id="ultima3">ACCIONES</th>
                        </tr>
                        <tr>
                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Docente</th>
                            <th style="border-left: black solid 1px;">Virtual</th>
                            <th>Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Presencial</th>
                            <th>Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total</th>
                            <th>Total Calificadas</th>
                            <th>%</th>

                            <th style="border-left: black solid 2px;">Total Virtual</th>
                            <th>Total Calificadas Virtuales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total Presencial</th>
                            <th>Total Calificadas Presenciales</th>
                            <th>%</th>
                            <th style="border-left: black solid 1px;">Total Asistencias</th>
                            <th>Total Asistencias Calificadas</th>
                            <th>%</th>
                        </tr>
                    </thead> 
                </table>
            </div>
        </div>
    </div>
</div>
@include('perfilEstudiante.Asistencias.Individuales.modal.detalles_sesiones')
@push('scripts')
{!!Html::script('/js/asistencias_individuales.js')!!}
@endpush
@endsection
