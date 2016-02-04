<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Museu Virtual - Angola</title>

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('/css/maps.css') }}" rel="stylesheet">

    <link href="{{ asset('/js/v3.6.0/css/ol.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/jquery-ui_mycustom.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/img_preview.css') }}" rel="stylesheet">



    <!-- Scripts -->
    <script src="{{ asset('/js/jquery.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/masonry.pkgd.min.js') }}"></script>

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you records the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-67479488-1', 'auto');
    ga('send', 'pageview');

</script>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a class="navbar-brand dropdown-toggle" data-toggle="dropdown" href="#">Museu Virtual
                        <span class="caret"></span></a></a>
                    <ul class="dropdown-menu">
                        <li><a href="/about">Acerca do Museu</a></li>
                        <li><a href="/support">Apoios</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/home') }}">Home</a></li>
                <li><a href="{{ url('/records') }}">Ver Registos</a></li>

                @if (Auth::user())
                    <li><a class="emphasis" href="{{ url('/records/create') }}"><span class="glyphicon glyphicon-plus" style="color: blue"></span> Novo Registo</a></li>
                @endif

                @if (Auth::user())
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Minha Conta
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/records/my">Meus Registos</a></li>
                            <li class="divider"></li>
                            <li><a href="/gazeteer/my">Meus Locais</a></li>
                            <li><a href="{{ url('/gazeteer/create') }}">Adicionar Local</a></li>

                            <li class="divider"></li>
                            <li><a href="/users/profile">Informação Pessoal</a></li>
                        </ul>
                    </li>
                @endif

                @if (Auth::user())
                    @if (Auth::user()->level>=1)
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Expert Admin
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/records/listpending/accept">Aceitar Registos</a></li>
                            <li><a href="/records/listpending/confirm">Confirmar Espécies</a></li>
                            <li><a href="/records/listpending/rejected">Registos Rejeitados</a></li>
                            <li><a href="#">Editar Registos</a>
                            <li class="divider"></li>
                            <li><a href="/taxonomylist/mammal">Gestão de Espécies</a></li>
                            <li class="divider"></li>
                            <li><a href="/articles/create">Criar Artigo</a></li>
                        </ul>
                    </li>
                    @endif
                @endif

                @if (Auth::user())
                    @if (Auth::user()->level>=2)
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Admin
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/users/manage">Utilizadores e Permisões</a></li>
                            <li><a href="/users/validate">Utilizadores por Validar</a></li>
                        </ul>
                    </li>
                    @endif
                @endif


            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li><a href="{{ url('/auth/login') }}">Login</a></li>
                    <li><a href="{{ url('/auth/register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<!-- Modal Para TODAS as imagens gerais do museu -->
<div id="ImageModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <img id="modalimg" class="img-responsive" src="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

@if (Auth::guest())
    <div class="container">

        <div class="alert alert-warning" style="padding-top: 5px; padding-bottom: 5px">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <div style="width: 10%; float: left;">
                <span class="glyphicon glyphicon-info-sign" style="font-size:x-large ;color:firebrick"></span>
            </div>
            <div>
                <p>
                    Para submeter registos e poder aceder a
                    todas as funcionalidades do museu faça <a href="{{url("auth/login")}}">login</a> com o seu utilizador
                    ou se ainda não tiver um, <a href="{{url("auth/register")}}">registe-se agora</a>.
                </p>
            </div>
        </div>
    </div>

@endif

@yield('content')

<script>
    $(document).ready(function(){
        $('img').click(function(){
            src= ($(this).attr('src'));
            $("#modalimg").attr('src',src);

        })
    })
</script>

</body>
</html>