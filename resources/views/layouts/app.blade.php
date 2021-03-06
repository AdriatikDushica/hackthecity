<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Gran Turismo</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://npmcdn.com/leaflet@0.7.7/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/0.5.0/MarkerCluster.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/0.5.0/MarkerCluster.Default.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/basic.min.css" />

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Gran Turismo
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li class="{{ Request::is('login*') ? 'active' : '' }}"><a href="{{ url('/login') }}">Login</a></li>
                        <li class="{{ Request::is('register*') ? 'active' : '' }}"><a href="{{ url('/register') }}">Registrati</a></li>
                    @else
                        <li class="{{ Request::is('home*') ? 'active' : '' }}"><a href="{{ url('/home') }}"><i class="fa fa-picture-o" aria-hidden="true"></i> Le mie foto</a></li>
                        <li class="{{ Request::is('liked*') ? 'active' : '' }}"><a href="{{ url('/liked') }}"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Foto piaciute</a></li>
                        <li class="dropdown" id="notifications-tab">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-bell" aria-hidden="true"></i> <span class="badge" id="badge">{{ Auth::user()->notifications->count() }}</span></a>
                            <ul class="dropdown-menu" style="width: 200px;">
                                @forelse(Auth::user()->notifications as $notification)
                                    @if($notification->type=='like')
                                        <li class="notification-row" style="white-space: normal;">
                                            <a style="white-space: normal;" href="{{ url('locations/'.$notification->location->id) }}">L'utente {{ $notification->userFrom->name }} ha messo mi piace alla tua foto</a>
                                        </li>
                                    @elseif($notification->type=='comment')
                                        <li class="notification-row" style="white-space: normal;">
                                            <a style="white-space: normal;" href="{{ url('locations/'.$notification->location->id) }}">L'utente {{ $notification->userFrom->name }} ha commentato una tua foto</a>
                                        </li>
                                    @endif
                                @empty
                                    <li class="notification-row">Non sono presenti notifiche</li>
                                @endforelse
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                @if(Auth::user()->avatar)
                                    <img class="avatar img-circle" src="{{ Auth::user()->avatar }}"  />
                                @endif
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>

                <form class="navbar-form navbar-right">
                    <a href="{{ url('home/create') }}" type="submit" class="btn btn-danger"><i class="fa fa-plus-circle" aria-hidden="true"></i> Carica foto</a>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        @include('partials.info')
    </div>

    @yield('content')

    <!-- Scripts -->
    <script src="https://npmcdn.com/leaflet@0.7.7/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/0.5.0/leaflet.markercluster.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>
    <script src="/js/app.js"></script>
</body>
</html>
