<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  @auth
    <style media="screen"> .user-avatar-nav { background-image: url('{{ asset('storage/avatars/'.Auth::user()->avatar) }}'); } </style>
  @endauth

</head>
<body>
  <div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">

      <div class="container">

        <a class="navbar-brand" href="{{ url('/') }}">
          {{ config('app.name', 'Laravel') }}
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav mr-auto">
            @auth
              <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a></li>
              @if(Auth::user()->hasRole('notas'))
                <li class="nav-item"><a class="nav-link" href="{{ route('notas.index') }}">Notas</a></li>
              @endif
            @endauth
          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">

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

              @if(Auth::user()->hasRole('admin'))
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    Admin
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('usuarios.index') }}"><i class="fa fa-fw fa-user"></i> Usuarios</a>
                    <a class="dropdown-item" href="{{ route('roles.index') }}"><i class="fa fa-fw fa-key"></i> Roles de usuarios</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logs') }}"><i class="fa fa-fw fa-list-alt"></i> Logs</a>
                  </div>
                </li>
              @endif

              <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                  <div class="user-avatar-nav"></div>
                  {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ route('profile.index') }}"><i class="fa fa-fw fa-pencil"></i> Perfil</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-fw fa-times"></i> {{ __('Logout') }}
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </div><!-- /.dropdown-menu -->
              </li>

            @endguest
          </ul>
        </div><!-- /.collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->

    <main class="py-4">
        @yield('content')
    </main>

  </div><!-- /#app -->

  <script type="text/javascript">
    window.addEventListener('load', function(){
      $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
      });
    });
  </script>

  @yield('footer_scripts')

</body>
</html>
