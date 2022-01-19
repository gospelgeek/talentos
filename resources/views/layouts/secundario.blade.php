<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="widht=device-widht, initial-section">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{ asset("css/app.css") }}">
        
        <title>@yield('title')</title>
    </head>
    <body> 

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="#">Datos del perfil del estudiante</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <a class="nav-link" href="/"> <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"></a>
              </li>
            </ul>
          </div>
        </nav>
        

        <div class="container">

          @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif

            @include('vistasParciales.sessionStatus')

            @yield('content')
        </div>
        <link rel="stylesheet" type="text/css" href="{{asset("css/app.css")}}">
        <script src="{{asset("js/app.js")}}"></script>
    </body>
</html>