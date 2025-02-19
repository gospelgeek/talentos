@extends('layouts.dashboard')
@section('title', 'Caracterización Socioeducativa')
@section('content')
@include('../alerts.success')
@include('../alerts.request')

<div class="container-fluid">
    <input type="hidden" id="roles" value="{{ auth()->user()->rol_id }}">    
    <h1 style="text-align:center;">CARACTERIZACIÓN SOCIOEDUCATIVA</h1>
    <div class="card">         
        <div class="card-body">
            <div class="btn-group">
                <div class="col-xs-12 col-sm-12 form-group {{$errors->has('body') ? 'has-errors' : ''}}">
                    <select id="intentos" class="form-control">
                        <option>Seleccionar diligenciamiento</option>
                        <option value="1">Primer diligenciamiento (Marzo)</option>
                        <option value="2">Segundo diligenciamiento (Mayo)</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
              <div id="tabla_1" class="table-responsive" style='display:none'>  
                <table id="marzo" class="table table-striped">
                    <thead>
                        <tr>
                            <th rowspan="2">Nombres</th>
                            <th rowspan="2">Apellidos</th>
                            <th rowspan="2">Tipo Doc.</th>
                            <th rowspan="2">Documento</th>
                            <th rowspan="2">Grupo</th>
                            <th rowspan="2">Cohorte</th>
                            <th rowspan="2">Estado</th>
                            <th rowspan="2">Profesional</th>
                            <th rowspan="2">Fecha</th>
                            <th rowspan="2">Intento</th>
                            <th colspan="4">DIMENSIÓN FAMILIAR</th>
                            <th colspan="5">DIMENSIÓN ECONOMICA</th>
                            <th colspan="13">DIMENSIÓN ACADEMICA</th>
                            <th colspan="18">DIMENSIÓN INDIVIDUAL</th>
                            <th colspan="18">SIN DIMENSIÓN</th>       
                            <th rowspan="2">ACCIONES</th>
                        </tr>

                        <tr>
                            <th title="¿Qué puedes decir sobre las relaciones con tu familia?">¿Qué puedes decir...</th>
                            <th title="¿Qué opina tu familia sobre la educación?">¿Qué opina tu...</th>
                            <th title="¿Cómo son las relaciones en tu familia?">¿Cómo son las...</th>
                            <th>NIVEL RIESGO FAMILIAR</th>

                            <th>Trabajas actualmente</th>
                            <th title="Aproximadamente ¿cuantas horas a la semana dedicas a tu trabajo?">Aproximadamente...</th>
                            <th title="¿Consideras que el trabajo que realizas puede afectar tu participación en el programa?">¿Consideras que el...</th>
                            <th title="¿Cuál de las siguientes descripciones refleja de mejor forma tu situación económica actual?">¿Cuál de las siguientes...</th>
                            <th>NIVEL RIESGO ECONOMICO</th>

                            <th title="¿Te consideras una persona disciplinada?">¿Te consideras...</th>
                            <th title="¿Cómo te va con el cumplimiento de tus tareas y proyectos?">¿Cómo te va...</th>
                            <th title="De los siguientes elementos ¿cuáles están a tu disposición en tu hogar? [Computador]">De los siguientes...</th>
                            <th title="De los siguientes elementos ¿cuáles están a tu disposición en tu hogar? [Internet domiciliario]">De los siguientes...</th>
                            <th title="De los siguientes elementos ¿cuáles están a tu disposición en tu hogar? [Internet por medio de datos moviles]">De los siguientes...</th>
                            <th title="De los siguientes elementos ¿cuáles están a tu disposición en tu hogar? [Smartphone o tablet]">De los siguientes...</th>
                            <th title="De los siguientes elementos ¿cuáles están a tu disposición en tu hogar? [Biblioteca con libros académicos]">De los siguientes...</th>
                            <th title="¿Cómo te sientes antes los retos de la Universidad?">¿Cómo te sientes...</th>
                            <th title="¿Qué tipo de estudiante crees que eres?">¿Qué tipo de...</th>
                            <th title="¿Cómo has construido tus proyectos y expectativas?">¿Cómo has construido...</th>
                            <th title="¿Qué has hecho para lograr alcanzar tus metas y desarrollar tus proyectos?">¿Qué has hecho...</th>
                            <th title="¿Te inclinas por algún campo profesional?">¿Te inclinas por...</th>
                            <th>NIVEL RIESGO ACADEMICO</th>

                            <th title="¿Actualmente realizas alguna actividad extracurricular? [Práctica de un deporte a nivel competitivo]">¿Actualmente realizas...</th>
                            <th title="¿Actualmente realizas alguna actividad extracurricular? [Prácticas artísticas (música, teatro, pintura, etc)]">¿Actualmente realizas...</th>
                            <th title="¿Actualmente realizas alguna actividad extracurricular? [Servicio en voluntariado (grupos comunitarios, defensa civil, etc)]">¿Actualmente realizas...</th>
                            <th title="¿Actualmente realizas alguna actividad extracurricular? [Otros cursos (idiomas, sistemas, etc)]">¿Actualmente realizas...</th>
                            <th title="¿Actualmente realizas alguna actividad extracurricular? [Ayudar en labores domésticas ]">¿Actualmente realizas...</th>
                            <th title="¿Actualmente realizas alguna actividad extracurricular? [Debo cuidar a alguien (hijos, familiar, etc)]">¿Actualmente realizas...</th>
                            <th title="¿Cuántas horas a la semana dedicas a estas actividades extracurriculares?">¿Cuántas horas a...</th>
                            <th title="¿Qué puedes decir acerca de tu historia personal?">¿Qué puedes decir...</th>
                            <th title="¿Qué puedes decir acerca de ti?">¿Qué puedes decir...</th>
                            <th title="¿Qué puedes decir sobre tu carácter?">¿Qué puedes decir...</th>
                            <th title="">¿Buscas ayuda?</th>
                            <th title="">¿Cómo está tu salud?</th>
                            <th title="¿Qué medidas has tomado frente a tu salud?">¿Qué medidas has...</th>
                            <th title="¿Qué tipo de asesoría profesional has recibido?">¿Qué tipo de...</th>
                            <th title="¿Cómo te sientes respecto al tema de la identidad de género y la identidad sexual?">¿Cómo te sientes...</th>
                            <th title="¿Cómo está tu situación afectiva y/o de pareja?">¿Cómo está tu...</th>
                            <th>¿Qué tal tus amistades?</th>
                            <th>NIVEL RIESGO INDIVIDUAL</th>

                            <th>Tipo de trabajo</th>
                            <th title="¿En que nivel dependes de tu familia para cubrir tus gastos (vivienda, transporte, estudio, alimentación, etc.)?">¿En que nivel...</th>
                            <th title="¿Con quién vives actualmente?">¿Con quién...</th>
                            <th title="¿Cual es el máximo nivel educativo alcanzado por tus padres, hermanos u otra persona a cargo de tu educación? [Padre]">¿Cual es el...</th>
                            <th title="¿Cual es el máximo nivel educativo alcanzado por tus padres, hermanos u otra persona a cargo de tu educación? [Madre]">¿Cual es el...</th>
                            <th title="¿Cual es el máximo nivel educativo alcanzado por tus padres, hermanos u otra persona a cargo de tu educación? [Hermanos]">¿Cual es el...</th>
                            <th title="¿Cual es el máximo nivel educativo alcanzado por tus padres, hermanos u otra persona a cargo de tu educación? [Otra persona a cargo tuyo (abuelos, tios, etc)]">¿Cual es el...</th>
                            <th title="De los siguientes elementos ¿cuáles están a tu disposición en tu hogar? [Espacio de estudio independiente]">De los siguientes...</th>
                            <th title="¿Cómo llegaste al programa? (selecciona la descripción que se aproxime mas a tu situación)">¿Cómo llegaste al...</th>
                            <th title="¿Tus padres y/o abuelos han migrado a Cali desde otras zonas del país?Padres y/o Abuelos">¿Tus padres y/o...</th>
                            <th title="En caso de responder afirmativamente la anterior pregunta, escoge el departamento desde el que han migrado:">En caso de...</th>
                            <th title="¿Naciste en la ciudad de Cali?">¿Naciste en la...</th>
                            <th title="Si respondiste no: ¿Cuánto tiempo has vivido en la ciudad de Cali?">Si respondiste no:...</th>
                            <th title="¿En qué zona de la ciudad vives?">¿En qué zona...</th>
                            <th title="¿Qué tanto conoces la ciudad?">¿Qué tanto...</th>
                            <th title="¿Cuál es el sector de la ciudad que mejor conoces?">¿Cuál es el...</th>
                            <th title="¿Cuál es el sector que más te gusta?">¿Cuál es el...</th>
                            <th title="¿Te gustaría continuar viviendo en Cali?">¿Te gustaría...</th>
                        </tr>
                    </thead>
                </table>
              </div>
              <div id="tabla_2" class="table-responsive" style='display:none'>  
                <table id="mayo" class=" table table-striped">
                    <thead>
                        <tr>
                            <th rowspan="2">Nombres</th>
                            <th rowspan="2">Apellidos</th>
                            <th rowspan="2">Tipo Doc.</th>
                            <th rowspan="2">Documento</th>
                            <th rowspan="2">Grupo</th>
                            <th rowspan="2">Cohorte</th>
                            <th rowspan="2">Estado</th>
                            <th rowspan="2">Profesional</th>
                            <th rowspan="2">Fecha</th>
                            <th rowspan="2">Intento</th>
                            <th colspan="4">DIMENSIÓN FAMILIAR</th>
                            <th colspan="5">DIMENSIÓN ECONOMICA</th>
                            <th colspan="15">DIMENSIÓN ACADEMICA</th>
                            <th colspan="18">DIMENSIÓN INDIVIDUAL</th>
                            <th colspan="20">SIN DIMENSIÓN</th>  
                            <th rowspan="2">ACCIONES</th>
                        </tr>

                       <tr>
                            <th title="¿Qué puedes decir sobre las relaciones con tu familia?">¿Qué puedes decir...</th>
                            <th title="¿Qué opina tu familia sobre la educación?">¿Qué opina tu...</th>
                            <th title="¿Cómo son las relaciones en tu familia?">¿Cómo son las...</th>
                            <th>NIVEL RIESGO FAMILIAR</th>

                            <th>Trabajas actualmente</th>
                            <th title="Aproximadamente ¿cuantas horas a la semana dedicas a tu trabajo?">Aproximadamente...</th>
                            <th title="¿Consideras que el trabajo que realizas puede afectar tu participación en el programa?">¿Consideras que el...</th>
                            <th title="¿Cuál de las siguientes descripciones refleja de mejor forma tu situación económica actual?">¿Cuál de las siguientes...</th>
                            <th>NIVEL RIESGO ECONOMICO</th>

                            <th title="¿Te consideras una persona disciplinada?">¿Te consideras...</th>
                            <th title="¿Cómo te va con el cumplimiento de tus tareas y proyectos?">¿Cómo te va...</th>
                            <th title="De los siguientes elementos ¿cuáles están a tu disposición en tu hogar? [Computador]">De los siguientes...</th>
                            <th title="De los siguientes elementos ¿cuáles están a tu disposición en tu hogar? [Internet domiciliario]">De los siguientes...</th>
                            <th title="De los siguientes elementos ¿cuáles están a tu disposición en tu hogar? [Internet por medio de datos moviles]">De los siguientes...</th>
                            <th title="De los siguientes elementos ¿cuáles están a tu disposición en tu hogar? [Smartphone o tablet]">De los siguientes...</th>
                            <th title="De los siguientes elementos ¿cuáles están a tu disposición en tu hogar? [Biblioteca con libros académicos]">De los siguientes...</th>
                            <th title="¿Cómo te sientes antes los retos de la Universidad?">¿Cómo te sientes...</th>
                            <th title="¿Qué tipo de estudiante crees que eres?">¿Qué tipo de...</th>
                            <th title="¿Cómo has construido tus proyectos y expectativas?">¿Cómo has construido...</th>
                            <th title="¿Qué has hecho para lograr alcanzar tus metas y desarrollar tus proyectos?">¿Qué has hecho...</th>
                            <th title="¿Te inclinas por algún campo profesional?">¿Te inclinas por...</th>
                            <th title="¿Tienes grupos de estudio o compañeros(as) con los que te reúnes para realizar tus actividades?">¿Tienes grupos de...</th>
                            <th title="¿Cuantas horas al día aproximadamente dedicas a estudiar de manera independiente? (Es decir, además de las clases que tomas en el programa)">¿Cuantas horas al...</th>
                            <th>NIVEL RIESGO ECONOMICO</th>

                            <th title="¿Actualmente realizas alguna actividad extracurricular? [Práctica de un deporte a nivel competitivo]">¿Actualmente realizas...</th>
                            <th title="¿Actualmente realizas alguna actividad extracurricular? [Prácticas artísticas (música, teatro, pintura, etc)]">¿Actualmente realizas...</th>
                            <th title="¿Actualmente realizas alguna actividad extracurricular? [Servicio en voluntariado (grupos comunitarios, defensa civil, etc)]">¿Actualmente realizas...</th>
                            <th title="¿Actualmente realizas alguna actividad extracurricular? [Otros cursos (idiomas, sistemas, etc)]">¿Actualmente realizas...</th>
                            <th title="¿Actualmente realizas alguna actividad extracurricular? [Ayudar en labores domésticas ]">¿Actualmente realizas...</th>
                            <th title="¿Actualmente realizas alguna actividad extracurricular? [Debo cuidar a alguien (hijos, familiar, etc)]">¿Actualmente realizas...</th>
                            <th title="¿Cuántas horas a la semana dedicas a estas actividades extracurriculares?">¿Cuántas horas a...</th>
                            <th title="¿Qué puedes decir acerca de tu historia personal?">¿Qué puedes decir...</th>
                            <th title="¿Qué puedes decir acerca de ti?">¿Qué puedes decir...</th>
                            <th title="¿Qué puedes decir sobre tu carácter?">¿Qué puedes decir...</th>
                            <th title="">¿Buscas ayuda?</th>
                            <th title="">¿Cómo está tu salud?</th>
                            <th title="¿Qué medidas has tomado frente a tu salud?">¿Qué medidas has...</th>
                            <th title="¿Qué tipo de asesoría profesional has recibido?">¿Qué tipo de...</th>
                            <th title="¿Cómo te sientes respecto al tema de la identidad de género y la identidad sexual?">¿Cómo te sientes...</th>
                            <th title="¿Cómo está tu situación afectiva y/o de pareja?">¿Cómo está tu...</th>
                            <th>¿Qué tal tus amistades?</th>
                            <th>NIVEL RIESGO INDIVIDUAL</th>

                            <th>Tipo de trabajo</th>
                            <th title="¿En que nivel dependes de tu familia para cubrir tus gastos (vivienda, transporte, estudio, alimentación, etc.)?">¿En que nivel...</th>
                            <th title="¿Con quién vives actualmente?">¿Con quién...</th>
                            <th title="¿Cual es el máximo nivel educativo alcanzado por tus padres, hermanos u otra persona a cargo de tu educación? [Padre]">¿Cual es el...</th>
                            <th title="¿Cual es el máximo nivel educativo alcanzado por tus padres, hermanos u otra persona a cargo de tu educación? [Madre]">¿Cual es el...</th>
                            <th title="¿Cual es el máximo nivel educativo alcanzado por tus padres, hermanos u otra persona a cargo de tu educación? [Hermanos]">¿Cual es el...</th>
                            <th title="¿Cual es el máximo nivel educativo alcanzado por tus padres, hermanos u otra persona a cargo de tu educación? [Otra persona a cargo tuyo (abuelos, tios, etc)]">¿Cual es el...</th>
                            <th title="De los siguientes elementos ¿cuáles están a tu disposición en tu hogar? [Espacio de estudio independiente]">De los siguientes...</th>
                            <th title="¿Cómo llegaste al programa? (selecciona la descripción que se aproxime mas a tu situación)">¿Cómo llegaste al...</th>
                            <th title="¿Tus padres y/o abuelos han migrado a Cali desde otras zonas del país?Padres y/o Abuelos">¿Tus padres y/o...</th>
                            <th title="En caso de responder afirmativamente la anterior pregunta, escoge el departamento desde el que han migrado:">En caso de...</th>
                            <th title="¿Naciste en la ciudad de Cali?">¿Naciste en la...</th>
                            <th title="Si respondiste no: ¿Cuánto tiempo has vivido en la ciudad de Cali?">Si respondiste no:...</th>
                            <th title="¿En qué zona de la ciudad vives?">¿En qué zona...</th>
                            <th title="¿Qué tanto conoces la ciudad?">¿Qué tanto...</th>
                            <th title="¿Cuál es el sector de la ciudad que mejor conoces?">¿Cuál es el...</th>
                            <th title="¿Cuál es el sector que más te gusta?">¿Cuál es el...</th>
                            <th title="¿Te gustaría continuar viviendo en Cali?">¿Te gustaría...</th>
                            <th title="¿Qué programas académicos tienes en mente?">¿Qué programas...</th>
                            <th title="¿Qué campos de conocimiento o acción te interesan?">¿Qué campos de...</th>
                        </tr>
                    </thead>
                </table>
              </div>
            </div>
        </div>
    </div>
</div>

@push('scripts') 

    <script>

        $('#intentos').on('change', function() {
            var intento = document.getElementById("intentos").value;
            if(intento == 1){
                document.getElementById("tabla_1").removeAttribute('style', 'display:none');
                $('#marzo').DataTable().ajax.reload();
            }
            else{
                document.getElementById("tabla_1").setAttribute('style', 'display:none');
            }
            if(intento == 2){
                document.getElementById("tabla_2").removeAttribute('style', 'display:none'); 
                $('#mayo').DataTable().ajax.reload();
            }else{
                document.getElementById("tabla_2").setAttribute('style', 'display:none');
            }
        });

        $(document).ready(function(){
            var table_1 = $("#marzo").DataTable({
                "ajax":{
                    "method":"GET",
                    "url":"{{route('datos.caracterizacion_marzo')}}",
                },
                "columns":[
                    {data: 'nombres', className:'table-bordered'},
                    {data: 'apellidos', className:'table-bordered'},
                    {data: 'tipo_documento', className:'table-bordered'},
                    {data: 'documento', className:'table-bordered'},
                    {data: 'grupo', className:'table-bordered'},
                    {data: 'cohorte', className:'table-bordered'},
                    {data: 'estado', className:'table-bordered'},
                    {data: 'profesional', className:'table-bordered'},
                    {data: 'date_diligence', className:'table-bordered'},
                    {data: 'try', className:'table-bordered',render:function(data, row, type, meta){
                            if(data != null){
                                if(data == 1){
                                    return 'Primer diligenciamiento';
                                }else if(data == 2){
                                    return 'Segundo diligenciamiento';
                                }
                            }else{
                                return '-';
                            }
                        }
                    },
                    
                    {data: null, className:'dimension', render:function(data, row, type, meta){
                            if(data.score_36 != null && data.score_36 != ''){
                                if(data.score_36 == 1){
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_36+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_36 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_36+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_36 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_36+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_36 == 0){
                                    //console.log(data.score_36);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_36+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_36 != null && data.pre_36 != ''){
                                        return data.pre_36;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_37 != null && data.score_37 != ''){
                                if(data.score_37 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_37+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_37 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_37+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_37 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_37+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_37 == 0){
                                    //console.log(data.score_37);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_37+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_37 != null && data.pre_37 != ''){
                                        return data.pre_37;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_38 != null && data.score_38 != ''){
                                if(data.score_38 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_38+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_38 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_38+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_38 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_38+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_38 == 0){
                                    //console.log(data.score_38);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_38+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_38 != null && data.pre_38 != ''){
                                        return data.pre_38;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null, className:'riesgos', render:function(data, type, row, meta){
                            
                            let valores = [data.score_36,  data.score_37,  data.score_38];
                            var total = 0;
                            valores.forEach(function(numero, index){
                                if(!isNaN(numero)){
                                    total += numero;
                                }
                            });
                            
                            if(total == 7 || total == 8){
                                celda = '<div style="background-color: red;">'+
                                            '<td>'+'ALTO'+'</td>'+
                                        '</div>';
                                return celda;
                            }else if(total == 5 || total == 6){
                                celda = '<div style="background-color: yellow;">'+
                                            '<td>'+'MEDIO'+'</td>'+
                                        '</div>';
                                return celda;
                            }else if(total <= 4){
                                celda = '<div style="background-color: #7FFF00;">'+
                                            '<td>'+'BAJO'+'</td>'+
                                        '</div>';
                                return celda;    
                            }
                        }
                    },

                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_1 != null && data.score_1 != ''){
                                if(data.score_1 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_1+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_1 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_1+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_1 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_1+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_1 == 0){
                                    //console.log(data.score_1);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_1+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_1 != null && data.pre_1 != ''){
                                        return data.pre_1;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_6 != null && data.score_6 != ''){
                                if(data.score_6 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_6+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_6 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_6+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_6 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_6+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_6 == 0){
                                    //console.log(data.score_6);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_6+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_6 != null && data.pre_6 != ''){
                                        return data.pre_6;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_7 != null && data.score_7 != ''){
                                if(data.score_7 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_7+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_7 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_7+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_7 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_7+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_7 == 0){
                                    //console.log(data.score_7);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_7+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_7 != null && data.pre_7 != ''){
                                        return data.pre_7;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_4 != null && data.score_4 != ''){
                                if(data.score_4 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_4+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_4 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_4+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_4 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_4+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_4 == 0){
                                    //console.log(data.score_4);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_4+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_4 != null && data.pre_4 != ''){
                                        return data.pre_4;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null, className:'riesgos', render:function(data, type, row, meta){
                            let valores = [data.score_1,  data.score_6,  data.score_7,  data.score_4];
                            var total = 0;
                            valores.forEach(function(numero, index){
                                if(!isNaN(numero)){
                                    total += numero;
                                }
                            });
                            
                            if(total == 10 || total == 11){
                                celda = '<div style="background-color: red;">'+
                                            '<td>'+'ALTO'+'</td>'+
                                        '</div>';
                                return celda;
                            }else if(total >= 6 && total <= 9){
                                celda = '<div style="background-color: yellow;">'+
                                            '<td>'+'MEDIO'+'</td>'+
                                        '</div>';
                                return celda;
                            }else if(total <= 5){
                                celda = '<div style="background-color: #7FFF00;">'+
                                            '<td>'+'BAJO'+'</td>'+
                                        '</div>';
                                return celda;    
                            }
                        }
                    },

                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_28 != null && data.score_28 != ''){
                                if(data.score_28 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_28+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_28 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_28+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_28 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_28+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_28 == 0){
                                    //console.log(data.score_28);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_28+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_28 != null && data.pre_28 != ''){
                                        return data.pre_28;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_29 != null && data.score_29 != ''){
                                if(data.score_29 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_29+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_29 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_29+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_29 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_29+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_29 == 0){
                                    //console.log(data.score_29);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_29+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_29 != null && data.pre_29 != ''){
                                        return data.pre_29;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_54 != null && data.score_54 != ''){
                                if(data.score_54 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_54+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_54 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_54+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_54 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_54+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_54 == 0){
                                    //console.log(data.score_54);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_54+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_54 != null && data.pre_54 != ''){
                                        return data.pre_54;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_55 != null && data.score_55 != ''){
                                if(data.score_55 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_55+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_55 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_55+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_55 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_55+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_55 == 0){
                                    //console.log(data.score_55);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_55+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_55 != null && data.pre_55 != ''){
                                        return data.pre_55;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_56 != null && data.score_56 != ''){
                                if(data.score_56 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_56+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_56 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_56+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_56 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_56+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_56 == 0){
                                    //console.log(data.score_56);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_56+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_56 != null && data.pre_56 != ''){
                                        return data.pre_56;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_57 != null && data.score_57 != ''){
                                if(data.score_57 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_57+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_57 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_57+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_57 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_57+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_57 == 0){
                                    //console.log(data.score_57);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_57+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_57 != null && data.pre_57 != ''){
                                        return data.pre_57;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_58 != null && data.score_58 != ''){
                                if(data.score_58 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_58+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_58 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_58+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_58 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_58+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_58 == 0){
                                    //console.log(data.score_58);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_58+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_58 != null && data.pre_58 != ''){
                                        return data.pre_58;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_13 != null && data.score_13 != ''){
                                if(data.score_13 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_13+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_13 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_13+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_13 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_13+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_13 == 0){
                                    //console.log(data.score_13);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_13+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_13 != null && data.pre_13 != ''){
                                        return data.pre_13;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_23 != null && data.score_23 != ''){
                                if(data.score_23 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_23+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_23 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_23+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_23 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_23+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_23 == 0){
                                    //console.log(data.score_23);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_23+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_23 != null && data.pre_23 != ''){
                                        return data.pre_23;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_21 != null && data.score_21 != ''){
                                if(data.score_21 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_21+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_21 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_21+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_21 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_21+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_21 == 0){
                                    //console.log(data.score_21);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_21+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_21 != null && data.pre_21 != ''){
                                        return data.pre_21;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_22 != null && data.score_22 != ''){
                                if(data.score_22 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_22+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_22 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_22+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_22 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_22+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_22 == 0){
                                    //console.log(data.score_22);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_22+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_22 != null && data.pre_22 != ''){
                                        return data.pre_22;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_24 != null && data.score_24 != ''){
                                if(data.score_24 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_24+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_24 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_24+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_24 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_24+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_24 == 0){
                                    //console.log(data.score_24);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_24+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_24 != null && data.pre_24 != ''){
                                        return data.pre_24;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null, className:'riesgos',render:function(data, type, row, meta){
                            
                            let valores = [data.score_28,  data.score_29,  data.score_54,  data.score_55,  data.score_56,  data.score_57,  data.score_58,  data.score_13,  data.score_23,  data.score_21,  data.score_22,  data.score_24];
                            var total = 0;
                            valores.forEach(function(numero, index){
                                if(!isNaN(numero)){
                                    total += numero;
                                }
                            });
                            
                            if(total >= 17 && total <= 25){
                                celda = '<div style="background-color: red;">'+
                                            '<td>'+'ALTO'+'</td>'+
                                        '</div>';
                                return celda;
                            }else if(total >= 13 && total <= 16){
                                celda = '<div style="background-color: yellow;">'+
                                            '<td>'+'MEDIO'+'</td>'+
                                        '</div>';
                                return celda;
                            }else if(total <= 12){
                                celda = '<div style="background-color: #7FFF00;">'+
                                            '<td>'+'BAJO'+'</td>'+
                                        '</div>';
                                return celda;    
                            }
                        }
                    },

                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_8 != null && data.score_8 != ''){
                                if(data.score_8 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_8+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_8 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_8+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_8 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_8+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_8 == 0){
                                    //console.log(data.score_8);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_8+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_8 != null && data.pre_8 != ''){
                                        return data.pre_8;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_9 != null && data.score_9 != ''){
                                if(data.score_9 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_9+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_9 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_9+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_9 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_9+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_9 == 0){
                                    //console.log(data.score_9);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_9+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_9 != null && data.pre_9 != ''){
                                        return data.pre_9;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_10 != null && data.score_10 != ''){
                                if(data.score_10 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_10+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_10 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_10+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_10 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_10+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_10 == 0){
                                    //console.log(data.score_10);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_10+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_10 != null && data.pre_10 != ''){
                                        return data.pre_10;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_11 != null && data.score_11 != ''){
                                if(data.score_11 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_11+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_11 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_11+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_11 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_11+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_11 == 0){
                                    //console.log(data.score_11);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_11+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_11 != null && data.pre_11 != ''){
                                        return data.pre_11;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_12 != null && data.score_12 != ''){
                                if(data.score_12 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_12+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_12 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_12+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_12 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_12+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_12 == 0){
                                    //console.log(data.score_12);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_12+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_12 != null && data.pre_12 != ''){
                                        return data.pre_12;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_40 != null && data.score_40 != ''){
                                if(data.score_40 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_40+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_40 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_40+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_40 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_40+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_40 == 0){
                                    //console.log(data.score_40);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_40+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_40 != null && data.pre_40 != ''){
                                        return data.pre_40;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_39 != null && data.score_39 != ''){
                                if(data.score_39 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_39+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_39 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_39+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_39 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_39+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_39 == 0){
                                    //console.log(data.score_39);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_39+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_39 != null && data.pre_39 != ''){
                                        return data.pre_39;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_25 != null && data.score_25 != ''){
                                if(data.score_25 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_25+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_25 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_25+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_25 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_25+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_25 == 0){
                                    //console.log(data.score_25);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_25+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_25 != null && data.pre_25 != ''){
                                        return data.pre_25;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_26 != null && data.score_26 != ''){
                                if(data.score_26 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_26+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_26 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_26+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_26 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_26+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_26 == 0){
                                    //console.log(data.score_26);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_26+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_26 != null && data.pre_26 != ''){
                                        return data.pre_26;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_27 != null && data.score_27 != ''){
                                if(data.score_27 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_27+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_27 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_27+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_27 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_27+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_27 == 0){
                                    //console.log(data.score_27);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_27+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_27 != null && data.pre_27 != ''){
                                        return data.pre_27;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_31 != null && data.score_31 != ''){
                                if(data.score_31 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_31+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_31 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_31+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_31 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_31+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_31 == 0){
                                    //console.log(data.score_31);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_31+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_31 != null && data.pre_31 != ''){
                                        return data.pre_31;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_32 != null && data.score_32 != ''){
                                if(data.score_32 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_32+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_32 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_32+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_32 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_32+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_32 == 0){
                                    //console.log(data.score_32);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_32+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_32 != null && data.pre_32 != ''){
                                        return data.pre_32;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_30 != null && data.score_30 != ''){
                                if(data.score_30 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_30+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_30 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_30+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_30 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_30+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_30 == 0){
                                    //console.log(data.score_30);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_30+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_30 != null && data.pre_30 != ''){
                                        return data.pre_30;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_5 != null && data.score_5 != ''){
                                if(data.score_5 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_5+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_5 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_5+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_5 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_5+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_5 == 0){
                                    //console.log(data.score_5);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_5+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_5 != null && data.pre_5 != ''){
                                        return data.pre_5;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_34 != null && data.score_34 != ''){
                                if(data.score_34 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_34+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_34 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_34+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_34 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_34+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_34 == 0){
                                    //console.log(data.score_34);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_34+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_34 != null && data.pre_34 != ''){
                                        return data.pre_34;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_33 != null && data.score_33 != ''){
                                if(data.score_33 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_33+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_33 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_33+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_33 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_33+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_33 == 0){
                                    //console.log(data.score_33);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_33+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_33 != null && data.pre_33 != ''){
                                        return data.pre_33;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_35 != null && data.score_35 != ''){
                                if(data.score_35 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_35+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_35 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_35+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(data.score_35 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_35+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.score_35 == 0){
                                    //console.log(data.score_35);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_35+'</td>'+
                                            '</div>';
                                    return celda;
                                }else{
                                    if(data.pre_35 != null && data.pre_35 != ''){
                                        return data.pre_35;    
                                    }else{
                                        return '-';
                                    }
                                }
                            }
                        }
                    },
                    {data: null, className:'riesgos',render:function(data, type, row, meta){
                            
                            let valores = [parseFloat(data.score_8), parseFloat(data.score_9), parseFloat(data.score_10), parseFloat(data.score_11), parseFloat(data.score_12), parseFloat(data.score_40), parseFloat(data.score_39), parseFloat(data.score_25), parseFloat(data.score_26), parseFloat(data.score_27), parseFloat(data.score_31), parseFloat(data.score_32), parseFloat(data.score_30), parseFloat(data.score_5), parseFloat(data.score_34), parseFloat(data.score_33), parseFloat(data.score_35)];

                            var total = 0;
                            valores.forEach(function(numero, index){
                                if(!isNaN(numero)){
                                    total += numero;
                                }
                            });
                            
                            if(total >= 25 && total <= 37){
                                celda = '<div style="background-color: red;">'+
                                            '<td>'+'ALTO'+'</td>'+
                                        '</div>';
                                return celda;
                            }else if(total >= 19 && total <= 24){
                                celda = '<div style="background-color: yellow;">'+
                                            '<td>'+'MEDIO'+'</td>'+
                                        '</div>';
                                return celda;
                            }else if(total <= 18){
                                celda = '<div style="background-color: #7FFF00;">'+
                                            '<td>'+'BAJO'+'</td>'+
                                        '</div>';
                                return celda;    
                            }
                        }
                    },

                    {data: 'pre_2',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_3',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_14',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_15',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_16',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_17',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_18',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_19',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_20',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_41',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_42',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_43',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_44',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_45',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_46',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_47',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_48',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_49',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, meta, type){
                             mstr = '<div class="btn-group">'+
                                        '<div class="col-xs-6 col-sm-6 btn-group">'+
                                            '<tr id="1">'+'<td">'+'<a href="caracterizacion_individual/'+data.id_student+'" class="ver btn btn-block fa fa-eye fa" title="Ver estudiante"></a>'+'</td>'+'</tr>'+
                                            '</div>'+
                                        '</div>';
                            return mstr;
                        }
                    }
                ],
                "deferRender": true,"responsive": false,"processing": false, "fixedHeader": true,'serverSider':true,
                "paging": true, "lengthChange": false, "autoWidth": false,"order": [[0,'asc']],
                "dom":'Bfrtip',
                scrollY:        false,
                scrollX:        true,
                scrollCollapse: true,fixedColumns:{
                    leftColumns: 6
                },
                buttons:{
                    dom:{
                        button:{
                            className:'btn'
                        }
                    },
                    buttons:[
                        {
                            extend:"excelHtml5",
                            title:"",
                            filename:"reporte_caracterización_socioeducativa_marzo",
                            text:'Exportar a Excel',
                            className: 'btn-outline-success',
                            messageBottom: false,
                            customize:function(xlsx){
                                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                var mergeCells = $('mergeCells', sheet);
                            
                                var numrows = 2;
                                var clR = $('row', sheet);

                                //update Row
                                clR.each(function () {
                                    var attr = $(this).attr('r');
                                    var ind = parseInt(attr);
                                    ind = ind + numrows;
                                    $(this).attr("r", ind);
                                });

                                // Create row before data
                                $('row c ', sheet).each(function () {
                                    var attr = $(this).attr('r');
                                    var pre = attr.substring(0, 1);
                                    var ind = parseInt(attr.substring(1, attr.length));
                                    ind = ind + numrows;
                                    $(this).attr("r", pre + ind);
                                });

                                function Addrow(index, data) {
                                    var msg = '<row r="' + index + '">'
                                    for (var i = 0; i < data.length; i++) {
                                        var key = data[i].key;
                                        var value = data[i].value;
                                        msg += '<c t="inlineStr" r="' + key + index + '">';
                                        msg += '<is>';
                                        msg += '<t>' + value + '</t>';
                                        msg += '</is>';
                                        msg += '</c>';
                                    }
                                    msg += '</row>';
                                    return msg;
                                }

                                var titulo = "REPORTE DE CARACTERIZACIÓN SOCIOEDUCATIVA";
                                var r1 = Addrow(1, [{ key: 'A', value: titulo  }]);
                                var r2 = Addrow(2, [{ key: 'A', value: "Nombres" }])
                                var r3 = Addrow(2, [{ key: 'B', value: "Apellidos" }])
                                var r4 = Addrow(2, [{ key: 'C', value: "Tipo Documento" }])
                                var r5 = Addrow(2, [{ key: 'D', value: "N° Documento" }])
                                var r6 = Addrow(2, [{ key: 'E', value: "Grupo" }])
                                var r7 = Addrow(2, [{ key: 'F', value: "Linea" }])
                                var r8 = Addrow(2, [{ key: 'G', value: "Estado" }])
                                var r9 = Addrow(2, [{ key: 'H', value: "Profesional Encargado" }])
                                var r10 = Addrow(2, [{ key: 'I', value: "DIMENSIÓN FAMILIAR" }])
                                var r11 = Addrow(2, [{ key: 'M', value: "DIMENSIÓN ECONOMICA" }])
                                var r12 = Addrow(2, [{ key: 'R', value: "DIMENSIÓN ACADEMICA" }])
                                var r13 = Addrow(2, [{ key: 'AE', value: "DIMENSIÓN INDIVIDUAL" }]
                                    )

                                var r14 = Addrow(2, [{ key: 'AW', value: "SIN DIMENSIÓN" }])
                                var r15 = Addrow(2, [{ key: 'BO', value: "Fecha" }])
                                var r16 = Addrow(2, [{ key: 'BP', value: "Diligenciamiento" }])
                                sheet.childNodes[0].childNodes[1].innerHTML = r1 +r2+ r3+r4 +r5+ r6+r7 +r8+ r9 +r10 +r11+ r12+r13 +r14+ r15+r16+sheet.childNodes[0].childNodes[1].innerHTML;

                                $('row c[r="A1"]', sheet).attr( 's', '51' );
                                $('row c[r="A2"]', sheet).attr( 's', '2' );
                                $('row c[r="B2"]', sheet).attr( 's', '2' );
                                $('row c[r="C2"]', sheet).attr( 's', '2' );
                                $('row c[r="D2"]', sheet).attr( 's', '2' );
                                $('row c[r="E2"]', sheet).attr( 's', '2' );
                                $('row c[r="F2"]', sheet).attr( 's', '2' );
                                $('row c[r="G2"]', sheet).attr( 's', '2' );
                                $('row c[r="H2"]', sheet).attr( 's', '2' );
                                $('row c[r="I2"]', sheet).attr( 's', '2' );
                                $('row c[r="M2"]', sheet).attr( 's', '2' );
                                $('row c[r="R2"]', sheet).attr( 's', '2' );
                                $('row c[r="AE2"]', sheet).attr( 's', '2' );
                                $('row c[r="AW2"]', sheet).attr( 's', '2' );
                                $('row c[r="BO2"]', sheet).attr( 's', '2' );
                                $('row c[r="BP2"]', sheet).attr( 's', '2' );

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'A1:BP1',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'A2:A3',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'B2:B3',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'C2:C3',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'D2:D3',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'E2:E3',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'F2:F3',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'G2:G3',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'H2:H3',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'I2:L2',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'M2:Q2',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'R2:AD2',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'AE2:AV2',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'AW2:BN2',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'BO2:BO3',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'BP2:BP3',
                                    }
                                }));

                                mergeCells.attr('count', mergeCells.attr( 'count' )+1 );

                                function _createNode( doc, nodeName, opts ) {
                                    var tempNode = doc.createElement( nodeName );
 
                                    if ( opts ) {
                                        if ( opts.attr ) {
                                            $(tempNode).attr( opts.attr );
                                        }
 
                                        if ( opts.children ) {
                                            $.each( opts.children, function ( key, value ) {
                                                tempNode.appendChild( value );
                                            } );
                                        }
 
                                        if ( opts.text !== null && opts.text !== undefined ) {
                                            tempNode.appendChild( doc.createTextNode( opts.text ) );
                                        }
                                    }
                                    return tempNode;
                                }
                            },    
                        }
                    ]
                } 
            });
            var table_2 = $("#mayo").DataTable({
                "ajax":{
                    "method":"GET",
                    "url":"{{route('datos.caracterizacion_mayo')}}",
                },
                "columns":[
                    {data: 'nombres',className:'table-bordered'},
                    {data: 'apellidos',className:'table-bordered'},
                    {data: 'tipo_documento',className:'table-bordered'},
                    {data: 'documento',className:'table-bordered'},
                    {data: 'grupo',className:'table-bordered'},
                    {data: 'cohorte',className:'table-bordered'},
                    {data: 'estado',className:'table-bordered'},
                    {data: 'profesional',className:'table-bordered'},
                    {data: 'date_diligence', className:'table-bordered'},
                    {data: 'try', className:'table-bordered',render:function(data, row, type, meta){
                            if(data != null){
                                if(data == 1){
                                    return 'Primer diligenciamiento';
                                }else if(data == 2){
                                    return 'Segundo diligenciamiento';
                                }
                            }else{
                                return '-';
                            }
                        }
                    },
                    //dimension familiar
                    {data: null,className:'dimension', render:function(data, row, type, meta){
                            if(data.score_36 != null && data.score_36 != ''){
                                if(data.score_36 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_36+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_36 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_36+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_36 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_36+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_36 == 0){
                                    //console.log(data.score_36);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_36+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_36 != null && data.pre_36 != ''){
                                        return data.pre_36;    
                                    }else{
                                        return '-';
                                    }      
                            }
                        }
                    },
                    {data: null,className:'table-bordered',render:function(data, row, type, meta){
                            if(data.score_37 != null && data.score_37 != ''){
                               if(data.score_37 == 0){
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_37+'</td>'+
                                            '</div>';
                                    return celda;
                               }
                               if(data.score_37 == 1){
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_37+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_37 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_37+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_37 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_37+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.pre_37 != null && data.pre_37 != ''){
                                        return data.pre_37;    
                                 }else{
                                     return '-';
                                }
                            }
                        }
                    },
                    {data: null,className:'table-bordered',render:function(data, row, type, meta){
                            if(data.score_38 != null && data.score_38 != ''){
                               if(data.score_38 == 0){
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_38+'</td>'+
                                            '</div>';
                                    return celda;
                               }
                               if(data.score_38 == 1){
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_38+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_38 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_38+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_38 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_38+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                if(data.pre_38 != null && data.pre_38 != ''){
                                        return data.pre_38;    
                                 }else{
                                     return '-';
                                }
                            }
                        }
                    },
                   {data: null, className:'riesgos', render:function(data, type, row, meta){
                            
                            var total = parseFloat(data.score_36) + parseFloat(data.score_37) + parseFloat(data.score_38);
                            
                            if(!isNaN(total)){
                                    
                                if(total == 7 || total == 8){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+'ALTO'+'</td>'+
                                            '</div>';
                                    return celda;
                                }if(total == 5 || total == 6){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+'MEDIO'+'</td>'+
                                            '</div>';
                                    return celda;
                                }else if(total <= 4){
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+'BAJO'+'</td>'+
                                            '</div>';
                                    return celda;    
                                }
                            }else{
                                return '-';
                            }
                        }
                    },
                    
                    //dimension economica
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_1 != null && data.score_1 != ''){
                                if(data.score_1 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_1+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_1 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_1+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_1 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_1+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_1 == 0){
                                    //console.log(data.score_1);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_1+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_1 != null && data.pre_1 != ''){
                                        return data.pre_1;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_6 != null && data.score_6 != ''){
                                if(data.score_6 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_6+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_6 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_6+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_6 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_6+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_6 == 0){
                                    //console.log(data.score_6);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_6+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_6 != null && data.pre_6 != ''){
                                        return data.pre_6;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_7 != null && data.score_7 != ''){
                                if(data.score_7 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_7+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_7 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_7+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_7 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_7+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_7 == 0){
                                    //console.log(data.score_7);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_7+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_7 != null && data.pre_7 != ''){
                                        return data.pre_7;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_4 != null && data.score_4 != ''){
                                if(data.score_4 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_4+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_4 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_4+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_4 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_4+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_4 == 0){
                                    //console.log(data.score_4);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_4+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_4 != null && data.pre_4 != ''){
                                        return data.pre_4;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null, className:'riesgos',render:function(data, type, row, meta){
                            
                            let valores = [parseFloat(data.score_1), parseFloat(data.score_6), parseFloat(data.score_7), parseFloat(data.score_4)];
                            var total = 0;
                            valores.forEach(function(numero, index){
                                if(!isNaN(numero)){
                                    total += numero;
                                }
                            });

                            if(total == 10 || total == 11){
                                celda = '<div style="background-color: red;">'+
                                            '<td>'+'ALTO'+'</td>'+
                                        '</div>';
                                return celda;
                            }else if(total >= 6 && total <= 9){
                                celda = '<div style="background-color: yellow;">'+
                                            '<td>'+'MEDIO'+'</td>'+
                                        '</div>';
                                return celda;
                            }else if(total <= 5){
                                celda = '<div style="background-color: #7FFF00;">'+
                                            '<td>'+'BAJO'+'</td>'+
                                        '</div>';
                                return celda;    
                            }    
                        }
                    },
                    
                    //dimension academica
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_28 != null && data.score_28 != ''){
                                if(data.score_28 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_28+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_28 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_28+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_28 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_28+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_28 == 0){
                                    //console.log(data.score_28);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_28+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_28 != null && data.pre_28 != ''){
                                        return data.pre_28;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_29 != null && data.score_29 != ''){
                                if(data.score_29 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_29+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_29 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_29+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_29 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_29+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_29 == 0){
                                    //console.log(data.score_29);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_29+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_29 != null && data.pre_29 != ''){
                                        return data.pre_29;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_54 != null && data.score_54 != ''){
                                if(data.score_54 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_54+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_54 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_54+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_54 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_54+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_54 == 0){
                                    //console.log(data.score_54);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_54+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_54 != null && data.pre_54 != ''){
                                        return data.pre_54;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_55 != null && data.score_55 != ''){
                                if(data.score_55 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_55+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_55 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_55+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_55 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_55+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_55 == 0){
                                    //console.log(data.score_55);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_55+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_55 != null && data.pre_55 != ''){
                                        return data.pre_55;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_56 != null && data.score_56 != ''){
                                if(data.score_56 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_56+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_56 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_56+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_56 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_56+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_56 == 0){
                                    //console.log(data.score_56);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_56+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_56 != null && data.pre_56 != ''){
                                        return data.pre_56;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_57 != null && data.score_57 != ''){
                                if(data.score_57 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_57+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_57 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_57+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_57 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_57+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_57 == 0){
                                    //console.log(data.score_57);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_57+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_57 != null && data.pre_57 != ''){
                                        return data.pre_57;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_58 != null && data.score_58 != ''){
                                if(data.score_58 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_58+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_58 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_58+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_58 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_58+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_58 == 0){
                                    //console.log(data.score_58);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_58+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_58 != null && data.pre_58 != ''){
                                        return data.pre_58;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_13 != null && data.score_13 != ''){
                                if(data.score_13 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_13+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_13 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_13+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_13 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_13+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_13 == 0){
                                    //console.log(data.score_13);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_13+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_13 != null && data.pre_13 != ''){
                                        return data.pre_13;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_23 != null && data.score_23 != ''){
                                if(data.score_23 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_23+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_23 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_23+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_23 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_23+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_23 == 0){
                                    //console.log(data.score_23);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_23+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_23 != null && data.pre_23 != ''){
                                        return data.pre_23;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_21 != null && data.score_21 != ''){
                                if(data.score_21 == 1){
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_21+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_21 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_21+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_21 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_21+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_21 == 0){
                                    //console.log(data.score_21);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_21+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_21 != null && data.pre_21 != ''){
                                        return data.pre_21;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_22 != null && data.score_22 != ''){
                                if(data.score_22 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_22+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_22 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_22+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_22 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_22+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_22 == 0){
                                    //console.log(data.score_22);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_22+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_22 != null && data.pre_22 != ''){
                                        return data.pre_22;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_24 != null && data.score_24 != ''){
                                if(data.score_24 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_24+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_24 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_24+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_24 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_24+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_24 == 0){
                                    //console.log(data.score_24);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_24+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_24 != null && data.pre_24 != ''){
                                        return data.pre_24;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_52 != null && data.score_52 != ''){
                                if(data.score_52 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_52+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_52 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_52+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_52 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_52+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_52 == 0){
                                    //console.log(data.score_52);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_52+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_52 != null && data.pre_52 != ''){
                                        return data.pre_52;    
                                    }else{
                                        return '-';
                                    }   
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_53 != null && data.score_53 != ''){
                                if(data.score_53 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_53+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_53 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_53+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_53 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_53+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_53 == 0){
                                    //console.log(data.score_53);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_53+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_53 != null && data.pre_53 != ''){
                                        return data.pre_53;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null, className:'riesgos',render:function(data, type, row, meta){
                            let valores = [parseFloat(data.score_28),  parseFloat(data.score_29),  parseFloat(data.score_54),  parseFloat(data.score_55),  parseFloat(data.score_56),  parseFloat(data.score_57),  parseFloat(data.score_58),  parseFloat(data.score_13),  parseFloat(data.score_23),  parseFloat(data.score_21),  parseFloat(data.score_22),  parseFloat(data.score_24),  parseFloat(data.score_52),  parseFloat(data.score_53)];

                            total = 0;
                            valores.forEach(function(numero, index){
                                if(!isNaN(numero)){
                                    total += numero;
                                }
                            });

                            
                            if(total >= 17 && total <= 25){
                                celda = '<div style="background-color: red;">'+
                                            '<td>'+'ALTO'+'</td>'+
                                        '</div>';
                                return celda;
                            }else if(total >= 13 && total <= 16){
                                celda = '<div style="background-color: yellow;">'+
                                            '<td>'+'MEDIO'+'</td>'+
                                        '</div>';
                                return celda;
                            }else if(total <= 12){
                                celda = '<div style="background-color: #7FFF00;">'+
                                            '<td>'+'BAJO'+'</td>'+
                                        '</div>';
                                return celda;    
                            }
                        }
                    },
                    //dimension individual
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_8 != null && data.score_8 != ''){
                                if(data.score_8 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_8+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_8 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_8+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_8 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_8+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_8 == 0){
                                    //console.log(data.score_8);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_8+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_8 != null && data.pre_8 != ''){
                                        return data.pre_8;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_9 != null && data.score_9 != ''){
                                if(data.score_9 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_9+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_9 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_9+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_9 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_9+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_9 == 0){
                                    //console.log(data.score_9);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_9+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_9 != null && data.pre_9 != ''){
                                        return data.pre_9;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_10 != null && data.score_10 != ''){
                                if(data.score_10 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_10+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_10 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_10+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_10 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_10+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_10 == 0){
                                    //console.log(data.score_10);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_10+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_10 != null && data.pre_10 != ''){
                                        return data.pre_10;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_11 != null && data.score_11 != ''){
                                if(data.score_11 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_11+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_11 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_11+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_11 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_11+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_11 == 0){
                                    //console.log(data.score_11);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_11+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_11 != null && data.pre_11 != ''){
                                        return data.pre_11;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_12 != null && data.score_12 != ''){
                                if(data.score_12 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_12+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_12 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_12+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_12 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_12+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_12 == 0){
                                    //console.log(data.score_12);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_12+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_12 != null && data.pre_12 != ''){
                                        return data.pre_12;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_40 != null && data.score_40 != ''){
                                if(data.score_40 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_40+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_40 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_40+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_40 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_40+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_40 == 0){
                                    //console.log(data.score_40);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_40+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_40 != null && data.pre_40 != ''){
                                        return data.pre_40;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_39 != null && data.score_39 != ''){
                                if(data.score_39 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_39+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_39 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_39+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_39 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_39+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_39 == 0){
                                    //console.log(data.score_39);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_39+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_39 != null && data.pre_39 != ''){
                                        return data.pre_39;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_25 != null && data.score_25 != ''){
                                if(data.score_25 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_25+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_25 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_25+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_25 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_25+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_25 == 0){
                                    //console.log(data.score_25);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_25+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_25 != null && data.pre_25 != ''){
                                        return data.pre_25;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_26 != null && data.score_26 != ''){
                                if(data.score_26 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_26+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_26 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_26+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_26 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_26+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_26 == 0){
                                    //console.log(data.score_26);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_26+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_26 != null && data.pre_26 != ''){
                                        return data.pre_26;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_27 != null && data.score_27 != ''){
                                if(data.score_27 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_27+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_27 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_27+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_27 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_27+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_27 == 0){
                                    //console.log(data.score_27);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_27+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_27 != null && data.pre_27 != ''){
                                        return data.pre_27;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_31 != null && data.score_31 != ''){
                                if(data.score_31 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_31+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_31 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_31+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_31 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_31+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_31 == 0){
                                    //console.log(data.score_31);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_31+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_31 != null && data.pre_31 != ''){
                                        return data.pre_31;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_32 != null && data.score_32 != ''){
                                if(data.score_32 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_32+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_32 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_32+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_32 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_32+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_32 == 0){
                                    //console.log(data.score_32);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_32+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_32 != null && data.pre_32 != ''){
                                        return data.pre_32;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_30 != null && data.score_30 != ''){
                                if(data.score_30 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_30+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_30 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_30+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_30 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_30+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_30 == 0){
                                    //console.log(data.score_30);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_30+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_30 != null && data.pre_30 != ''){
                                        return data.pre_30;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_5 != null && data.score_5 != ''){
                                if(data.score_5 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_5+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_5 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_5+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_5 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_5+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_5 == 0){
                                    //console.log(data.score_5);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_5+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_5 != null && data.pre_5 != ''){
                                        return data.pre_5;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_34 != null && data.score_34 != ''){
                                if(data.score_34 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_34+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_34 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_34+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_34 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_34+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_34 == 0){
                                    //console.log(data.score_34);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_34+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_34 != null && data.pre_34 != ''){
                                        return data.pre_34;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_33 != null && data.score_33 != ''){
                                if(data.score_33 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_33+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_33 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_33+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_33 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_33+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_33 == 0){
                                    //console.log(data.score_33);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_33+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_33 != null && data.pre_33 != ''){
                                        return data.pre_33;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, type, meta){
                            if(data.score_35 != null && data.score_35 != ''){
                                if(data.score_35 == 1){

                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_35+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_35 == 2){
                                    celda = '<div style="background-color: yellow;">'+
                                                '<td>'+data.pre_35+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_35 == 3){
                                    celda = '<div style="background-color: red;">'+
                                                '<td>'+data.pre_35+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                                if(data.score_35 == 0){
                                    //console.log(data.score_35);
                                    celda = '<div style="background-color: #7FFF00;">'+
                                                '<td>'+data.pre_35+'</td>'+
                                            '</div>';
                                    return celda;
                                }
                            }else{
                                    if(data.pre_35 != null && data.pre_35 != ''){
                                        return data.pre_35;    
                                    }else{
                                        return '-';
                                    }
                            }
                        }
                    },
                    {data: null, className:'riesgos',render:function(data, type, row, meta){
                            
                            let valores = [parseFloat(data.score_8), parseFloat(data.score_9), parseFloat(data.score_10), parseFloat(data.score_11), parseFloat(data.score_12), parseFloat(data.score_40), parseFloat(data.score_39), parseFloat(data.score_25), parseFloat(data.score_26), parseFloat(data.score_27), parseFloat(data.score_31), parseFloat(data.score_32), parseFloat(data.score_30), parseFloat(data.score_5), parseFloat(data.score_34), parseFloat(data.score_33), parseFloat(data.score_35)];

                            var total = 0;
                            valores.forEach(function(numero, index){
                                if(!isNaN(numero)){
                                    total += numero;
                                }
                            });
                            
                            if(total >= 25 && total <= 37){
                                celda = '<div style="background-color: red;">'+
                                            '<td>'+'ALTO'+'</td>'+
                                        '</div>';
                                return celda;
                            }else if(total >= 19 && total <= 24){
                                celda = '<div style="background-color: yellow;">'+
                                            '<td>'+'MEDIO'+'</td>'+
                                        '</div>';
                                return celda;
                            }else if(total <= 18){
                                celda = '<div style="background-color: #7FFF00;">'+
                                            '<td>'+'BAJO'+'</td>'+
                                        '</div>';
                                return celda;    
                            }
                        }
                    },


                    {data: 'pre_2',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_3',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_14',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_15',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_16',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_17',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_18',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_19',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_20',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_41',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_42',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_43',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_44',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_45',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_46',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_47',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_48',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_49',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_50',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'pre_51',className:'table-bordered', render:function(data, row, type, meta){
                            if(data != null && data != ''){
                                return data;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: null,className:'table-bordered', render:function(data, row, meta, type){
                             mstr = '<div class="btn-group">'+
                                        '<div class="col-xs-6 col-sm-6 btn-group">'+
                                            '<tr id="1">'+'<td">'+'<a href="caracterizacion_individual/'+data.id_student+'" class="ver btn btn-block fa fa-eye fa" title="Ver estudiante"></a>'+'</td>'+'</tr>'+
                                            '</div>'+
                                        '</div>';
                            return mstr;
                        }
                    }
                ],
                "deferRender": true,"responsive": false,"processing": false, "fixedHeader": true,
                'serverSider':true,
                "paging": true, "lengthChange": false, "autoWidth": false,"order": [[0,'asc']],
                "dom":'Bfrtip',
                scrollY:        false,
                scrollX:        true,
                scrollCollapse: true,fixedColumns:{
                    leftColumns: 6
                },
                buttons:{
                    dom:{
                        button:{
                            className:'btn'
                        }
                    },
                    buttons:[
                        {
                            extend:"excelHtml5",
                            title:"",
                            filename:"reporte_caracterización_socioeducativa_mayo",
                            text:'Exportar a Excel',
                            className: 'btn-outline-success',
                            messageBottom: false,
                            customize:function(xlsx){
                                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                var mergeCells = $('mergeCells', sheet);
                            
                                var numrows = 2;
                                var clR = $('row', sheet);

                                //update Row
                                clR.each(function () {
                                    var attr = $(this).attr('r');
                                    var ind = parseInt(attr);
                                    ind = ind + numrows;
                                    $(this).attr("r", ind);
                                });

                                // Create row before data
                                $('row c ', sheet).each(function () {
                                    var attr = $(this).attr('r');
                                    var pre = attr.substring(0, 1);
                                    var ind = parseInt(attr.substring(1, attr.length));
                                    ind = ind + numrows;
                                    $(this).attr("r", pre + ind);
                                });

                                function Addrow(index, data) {
                                    var msg = '<row r="' + index + '">'
                                    for (var i = 0; i < data.length; i++) {
                                        var key = data[i].key;
                                        var value = data[i].value;
                                        msg += '<c t="inlineStr" r="' + key + index + '">';
                                        msg += '<is>';
                                        msg += '<t>' + value + '</t>';
                                        msg += '</is>';
                                        msg += '</c>';
                                    }
                                    msg += '</row>';
                                    return msg;
                                }

                                var titulo = "REPORTE DE CARACTERIZACIÓN SOCIOEDUCATIVA";
                                var r1 = Addrow(1, [{ key: 'A', value: titulo  }]);
                                var r2 = Addrow(2, [{ key: 'A', value: "Nombres" }])
                                var r3 = Addrow(2, [{ key: 'B', value: "Apellidos" }])
                                var r4 = Addrow(2, [{ key: 'C', value: "Tipo Documento" }])
                                var r5 = Addrow(2, [{ key: 'D', value: "N° Documento" }])
                                var r6 = Addrow(2, [{ key: 'E', value: "Grupo" }])
                                var r7 = Addrow(2, [{ key: 'F', value: "Linea" }])
                                var r8 = Addrow(2, [{ key: 'G', value: "Estado" }])
                                var r9 = Addrow(2, [{ key: 'H', value: "Profesional Encargado" }])
                                var r10 = Addrow(2, [{ key: 'I', value: "DIMENSIÓN FAMILIAR" }])
                                var r11 = Addrow(2, [{ key: 'M', value: "DIMENSIÓN ECONOMICA" }])
                                var r12 = Addrow(2, [{ key: 'R', value: "DIMENSIÓN ACADEMICA" }])
                                var r13 = Addrow(2, [{ key: 'AG', value: "DIMENSIÓN INDIVIDUAL" }]
                                    )

                                var r14 = Addrow(2, [{ key: 'AY', value: "SIN DIMENSIÓN" }])
                                var r15 = Addrow(2, [{ key: 'BS', value: "Fecha" }])
                                var r16 = Addrow(2, [{ key: 'BT', value: "Diligenciamiento" }])
                                sheet.childNodes[0].childNodes[1].innerHTML = r1 +r2+ r3+r4 +r5+ r6+r7 +r8+ r9 +r10 +r11+ r12+r13 +r14+ r15+r16+sheet.childNodes[0].childNodes[1].innerHTML;

                                $('row c[r="A1"]', sheet).attr( 's', '51' );
                                $('row c[r="A2"]', sheet).attr( 's', '2' );
                                $('row c[r="B2"]', sheet).attr( 's', '2' );
                                $('row c[r="C2"]', sheet).attr( 's', '2' );
                                $('row c[r="D2"]', sheet).attr( 's', '2' );
                                $('row c[r="E2"]', sheet).attr( 's', '2' );
                                $('row c[r="F2"]', sheet).attr( 's', '2' );
                                $('row c[r="G2"]', sheet).attr( 's', '2' );
                                $('row c[r="H2"]', sheet).attr( 's', '2' );
                                $('row c[r="I2"]', sheet).attr( 's', '2' );
                                $('row c[r="M2"]', sheet).attr( 's', '2' );
                                $('row c[r="R2"]', sheet).attr( 's', '2' );
                                $('row c[r="AG2"]', sheet).attr( 's', '2' );
                                $('row c[r="AY2"]', sheet).attr( 's', '2' );
                                $('row c[r="BS2"]', sheet).attr( 's', '2' );
                                $('row c[r="BT2"]', sheet).attr( 's', '2' );

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'A1:BR1',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'A2:A3',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'B2:B3',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'C2:C3',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'D2:D3',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'E2:E3',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'F2:F3',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'G2:G3',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'H2:H3',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'I2:L2',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'M2:Q2',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'R2:AF2',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'AG2:AX2',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'AY2:BR2',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'BS2:BS3',
                                    }
                                }));

                                mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'BT2:BT3',
                                    }
                                }));

                                mergeCells.attr('count', mergeCells.attr( 'count' )+1 );

                                function _createNode( doc, nodeName, opts ) {
                                    var tempNode = doc.createElement( nodeName );
 
                                    if ( opts ) {
                                        if ( opts.attr ) {
                                            $(tempNode).attr( opts.attr );
                                        }
 
                                        if ( opts.children ) {
                                            $.each( opts.children, function ( key, value ) {
                                                tempNode.appendChild( value );
                                            } );
                                        }
 
                                        if ( opts.text !== null && opts.text !== undefined ) {
                                            tempNode.appendChild( doc.createTextNode( opts.text ) );
                                        }
                                    }
                                    return tempNode;
                                }
                            },    
                        }
                    ]
                }
            });
        });

    </script>
 
@endpush
@endsection
