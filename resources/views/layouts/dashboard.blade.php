<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>

  {!!Html::style('/dashboard/dist/css/adminlte.min.css')!!}
  <!-- Google Font: Source Sans Pro -->
  {!!Html::style('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback')!!}
  <!-- Font Awesome Icons -->
  {!!Html::style('/dashboard/plugins/fontawesome-free/css/all.min.css')!!}
  <!-- Theme style -->
  {!!Html::style('/dashboard/dist/css/adminlte.min.css')!!}
  
  {!!Html::style('/dashboard/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')!!}
  {!!Html::style('/dashboard/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')!!}
  {!!Html::style('/dashboard/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')!!}
  {!!Html::style('/dashboard/plugins/fontawesome-free/css/all.min.css')!!}
  @stack('css')
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="../../index3.html" class="navbar-brand">
      <!--  <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
        <span class="brand-text font-weight-light">Talentos</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="estudiante" class="nav-link">Home</a>
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
                  </li>
                  -->
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
        <li class="nav-item">
          <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer"><i class="fas fa-user-lock"></i> cerrar sesi&oacute;n </a>
          </a>
        </li>
      </ul>
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
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
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
<!-- AdminLTE for demo purposes -->
{!!Html::script('/dashboard/dist/js/demo.js')!!}


{!!Html::script('/dashboard/plugins/datatables/jquery.dataTables.min.js')!!}

{!!Html::script('/dashboard/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')!!}

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

@stack('scripts')
</body>
</html>
