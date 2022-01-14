<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }} ">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {!!Html::style('/DataTables/bootstrap/css/bootstrap.css')!!}
    {!!Html::style('/dashboard/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')!!}
    {!!Html::style('/dashboard/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')!!}
    
    <link rel="stylesheet" type="text/css" href="/DataTables/DataTables/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="/DataTables/Responsive/css/responsive.bootstrap4.min.css">
</head>
<body>

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">

                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif

                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <a href="" class="dropdown-item dropdown-footer"><i class="fas fa-user-lock"></i>DATOS SOCIOECONOMICOS </a>
                        <a href="" class="dropdown-item dropdown-footer"><i class="fas fa-user-lock"></i>DATOS ACADEMICOS</a>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer"><i class="fas fa-user-lock"></i> cerrar sesi&oacute;n </a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer"><i class="fas fa-user-lock"></i> cerrar sesi&oacute;n </a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        
        </main>
        
    </div>
      
        <!-- SCRIPTS -->
      <!-- JQuery -->

    
     {!!Html::script('/dashboard/plugins/jquery/jquery.min.js')!!} 
    {!!Html::script('/dashboard/plugins/bootstrap/js/bootstrap.min.js')!!}
    {!!Html::script('/dashboard/plugins/datatables/jquery.dataTables.min.js')!!}
    {!!Html::script('/dashboard/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')!!}
    {!!Html::script('/dashboard/plugins/datatables-responsive/js/dataTables.responsive.min.js')!!}
    {!!Html::script('/dashboard/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')!!}
    {!!Html::script('/js/dep-mun.js')!!}

       
    
</body>
</html>
