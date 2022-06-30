<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="{{asset('img/logo.jpeg')}}">
  <title>@yield('title')</title>
  {!!Html::style('/css/css.css')!!}
  {!!Html::style('/dashboard/dist/css/adminlte.min.css')!!}
  <!-- Google Font: Source Sans Pro -->
  {!!Html::style('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback')!!}
  <!-- Font Awesome Icons
  {!!Html::style('/dashboard/plugins/fontawesome-free/css/all.min.css')!!} -->
  {!!Html::style('font-awesome-4.7.0/css/font-awesome.min.css')!!}
  <!-- Theme style -->
  {!!Html::style('/dashboard/dist/css/adminlte.min.css')!!}
  {!!Html::style('/css/css.css')!!}
  {!!Html::style('/dashboard/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')!!}
  {!!Html::style('/dashboard/plugins/datatables-fixedcolumns/css/fixedColumns.bootstrap4.min.css')!!}
  {!!Html::style('/dashboard/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')!!}
  {!!Html::style('/dashboard/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')!!}
  {!!Html::style('/toastr/toastr.min.css')!!}
  @stack('css')
</head>

<body class="hold-transition layout-top-nav">

<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="{{route('estudiante')}}" class="navbar-brand">
      <img src="{{asset('img/logo.jpeg')}}" alt="Logo" class="brand-image" >
        <span class="brand-text font-weight-light">PNA</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            
          </li>
          <!--
          <li class="nav-item">
            <a href="#" class="nav-link">Contact</a>
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Dropdown</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="#" class="dropdown-item">Some action </a></li>
              <li><a href="#" class="dropdown-item">Some other action</a></li>
              <li class="dropdown-divider"></li>-->

            <!-- Level two dropdown
              <li class="dropdown-submenu dropdown-hover">
                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Hover for action</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                  <li>
                    <a tabindex="-1" href="#" class="dropdown-item">level 2</a>
                  </li>
                  -->
            <!-- Level three dropdown
                  <li class="dropdown-submenu">
                    <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">level 2</a>
                    <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                      <li><a href="#" class="dropdown-item">3rd level</a></li>
                      <li><a href="#" class="dropdown-item">3rd level</a></li>
                    </ul>
                  </li>-->
     
                  <!-- End Level three 
                  
                  <li><a href="#" class="dropdown-item">level 2</a></li>
                  <li><a href="#" class="dropdown-item">level 2</a></li>
                </ul>
              </li>
             End Level two 
            </ul>
          </li>
        </ul>
        -->
            <!-- SEARCH FORM 
        <form class="form-inline ml-0 ml-md-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form>-->
        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
          <!-- Messages Dropdown Menu 
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-comments"></i>
            <span class="badge badge-danger navbar-badge"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item">-->
          <!-- Message Start 
              <div class="media">
                <img src="dashboard/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Brad Diesel
                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">Call me whenever you can...</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>-->
          <!-- Message End 
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
               Message Start 
              <div class="media">
                <img src="dashboard/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    John Pierce
                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">I got your message bro</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
               Message End 
            </a>
          -->
          <!--
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
            -->
          <!-- Message Start
              <div class="media">
                <img src="dashboard/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Nora Silvester
                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">The subject goes here</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
               -->
          <!-- Message End 
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
          </div>
        </li>-->
          <!-- Notifications Dropdown Menu
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge"></span>
          </a> -->
          <!--
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i>new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> new reports
              <span class="float-right text-muted text-sm">days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        
        </li>
        -->

          @if(auth()->user()->rol_id == 2 || auth()->user()->rol_id == 4)
          
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                ESTUDIANTES
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                <a class="dropdown-item" href="{{route('estudiante')}}">Reporte General</a>
                <a class="dropdown-item" href="{{route('estudiantes.estado')}}">Estado Estudiantes</a> 
                <a href="{{route('graficas')}}" class="dropdown-item"><i></i>Estadisticas Graficas</a>
                <a href="{{route('icfes')}}" class="dropdown-item"><i></i>Comparativo Icfes</a>
               </div>
              
          </li>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Administrativo
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
            <a href="{{route('almuerzos_estudiantes')}}" class="dropdown-item">Almuerzos</a>
            <a href="{{route('formalizacion')}}" class="dropdown-item">Formalizacion</a>
            <a class="dropdown-item" href="{{route('estudiantes_mayoria_edad')}}">Mayoria de edad</a>
          </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle"  id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Socioeducativo 
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
              <a href="{{route('socioeducativo')}}" class="dropdown-item">
                Asignacion Estudiantes</a>
              <a href="{{route('socioeducativo_reporte')}}" class="dropdown-item">
                Reporte socioeducativo</a>
              </div>
          </li>     
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="{{route('asistencias')}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Asistencias</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{route('asistencias')}}" class="dropdown-item">Asistencias Grupos</a></li>
              <li><a href="{{route('asistencias.estudiantes')}}" class="dropdown-item">Asitencias Individuales</a></li>
            </ul>
          </li>
          @endif
          @if(auth()->user()->rol_id == 1 || auth()->user()->rol_id == 5)
        <ul class="navbar-nav mr-auto">
                        <a  href="{{route('usuario')}}" class="dropdown-item dropdown-footer"><i></i>Usuarios</a>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"  id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Estudiantes 
                        </a>
                          <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                            <a class="dropdown-item" href="{{route('estudiante')}}">Reporte General</a>
                            <a class="dropdown-item" href="{{route('estudiantes.estado')}}">Estado Estudiantes</a>
                            <a href="{{route('graficas')}}" class="dropdown-item"><i></i>Estadisticas Graficas</a>
                          </div>
                      </li>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"  id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Socioeducativo 
                        </a>
                          <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                            <a href="{{route('socioeducativo')}}" class="dropdown-item">
                            Asignacion Estudiantes</a>
                            <a href="{{route('socioeducativo_reporte')}}" class="dropdown-item">
                            Reporte socioeducativo</a>
                          </div>
                      </li> 
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Administrativo
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                          <a href="{{route('almuerzos_estudiantes')}}" class="dropdown-item">Almuerzos</a>
                          <a class="dropdown-item" href="{{route('estudiantes_mayoria_edad')}}">Mayoria de edad</a>
                          <a  href="{{route('formalizacion')}}" class="dropdown-item">Formalizacion</a>
                        </div>
                      </li>
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Academico
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                          <a href="{{route('asignaturas')}}" class="dropdown-item">Asignaturas</a>
                          <a href="{{route('sesiones')}}" class="dropdown-item">Sesiones</a>
                        </div>
                      </li>
                        
                        <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="{{route('asistencias')}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Asistencias</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{route('asistencias')}}" class="dropdown-item">Asistencias Grupos</a></li>
              <li><a href="{{route('asistencias.estudiantes')}}" class="dropdown-item">Asitencias Individuales</a></li>
            </ul>
            </li>
        @endif
        @if(auth()->user()->rol_id == 3 || auth()->user()->rol_id == 6)
        <ul class="navbar-nav mr-auto">
                        <a  href="{{route('estudiante')}}" class="dropdown-item dropdown-footer"><i></i>Estudiantes</a>
                        <a href="{{route('graficas')}}" class="dropdown-item dropdown-footer"><i></i>Estadisticas Graficas</a>
                        <a class="disabled" style="display: none" href="{{route('asignaturas')}}" class="dropdown-item dropdown-footer"><i></i>Asignaturas</a>
                        <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="{{route('asistencias')}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Asistencias</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{route('asistencias')}}" class="dropdown-item">Asistencias Grupos</a></li>
              <li><a href="{{route('asistencias.estudiantes')}}" class="dropdown-item">Asitencias Individuales</a></li>
            </ul>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle"  id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Socioeducativo 
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
              <a href="{{route('socioeducativo')}}" class="dropdown-item">
                Asignacion Estudiantes</a>
              <a href="{{route('socioeducativo_reporte')}}" class="dropdown-item">
                Reporte socioeducativo</a>
              </div>
          </li> 
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   Academico
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                   <a href="{{route('asignaturas')}}" class="dropdown-item">Asignaturas</a>
                   <a href="{{route('sesiones')}}" class="dropdown-item">Sesiones</a>
                </div>
             </li>

        </ul>
        @endif
        <li class="nav-item">
          <a class="dropdown-item dropdown-footer"><i class="fa fa-user"></i>&nbsp;{{ auth()->user()->name }}</a>
          
        </li>
        <li class="nav-item">
          <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer"><i class="fas fa-user-lock"></i> cerrar sesi&oacute;n </a>
        </li>
      </div>
    </nav>
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>@yield('titulo_secundario')</h1>
            </div><!-- /.col -->
            <!--
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Layout</a></li>
              <li class="breadcrumb-item active">Top Navigation</li>
            </ol>
          </div>-->
            <!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          @yield('content')


        </div><!-- /.container-fluid -->
      </section>

      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">

      </div>
      <!-- Default to the left -->
      <strong><a href=""></a></strong>
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  {!!Html::script('/dashboard/plugins/jquery/jquery.min.js')!!}
  <!-- Bootstrap 4 -->
  {!!Html::script('/dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js')!!}
  <!-- AdminLTE App -->
  {!!Html::script('/dashboard/dist/js/adminlte.min.js')!!}
  <!-- AdminLTE for demo purposes
{!!Html::script('/dashboard/dist/js/demo.js')!!}
 -->
  {!!Html::script('/toastr/toastr.min.js')!!}

  {!!Html::script('/dashboard/plugins/datatables/jquery.dataTables.min.js')!!}

  {!!Html::script('/dashboard/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')!!}

  {!!Html::script('/dashboard/plugins/datatables-fixedcolumns/js/dataTables.fixedColumns.min.js')!!}

  {!!Html::script('/dashboard/plugins/datatables-fixedcolumns/js/fixedColumns.bootstrap4.min.js')!!}

  {!!Html::script('/dashboard/plugins/datatables-responsive/js/dataTables.responsive.min.js')!!}

  {!!Html::script('dashboard/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')!!}

  {!!Html::script('dashboard/plugins/datatables-buttons/js/dataTables.buttons.min.js')!!}

  {!!Html::script('dashboard/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')!!}

  {!!Html::script('dashboard/plugins/jszip/jszip.min.js')!!}

  {!!Html::script('dashboard/plugins/pdfmake/pdfmake.min.js')!!}

  {!!Html::script('dashboard/plugins/pdfmake/vfs_fonts.js')!!}

  {!!Html::script('dashboard/plugins/datatables-buttons/js/buttons.html5.min.js')!!}

  {!!Html::script('dashboard/plugins/datatables-buttons/js/buttons.print.min.js')!!}

  {!!Html::script('/dashboard/plugins/datatables-buttons/js/buttons.colVis.min.js')!!}
  <script type="text/javascript">
    const $dropdown = $(".dropdown");
    const $dropdownToggle = $(".dropdown-toggle");
    const $dropdownMenu = $(".dropdown-menu");
    const showClass = "show";
    $(window).on("load resize", function() {
      if (this.matchMedia("(min-width: 768px)").matches) {
        $dropdown.hover(
          function() {
            const $this = $(this);
            $this.addClass(showClass);
            $this.find($dropdownToggle).attr("aria-expanded", "true");
            $this.find($dropdownMenu).addClass(showClass);
          },
          function() {
            const $this = $(this);
            $this.removeClass(showClass);
            $this.find($dropdownToggle).attr("aria-expanded", "false");
            $this.find($dropdownMenu).removeClass(showClass);
          }
        );
      } else {
        $dropdown.off("mouseenter mouseleave");
      }
    });
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  @stack('scripts')
</body>

</html>
