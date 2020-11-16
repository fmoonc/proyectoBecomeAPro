<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app1.css')}}">
    <title>Inicio</title>
</head>

<body class="fondo">
    <div class="row justify-content-center">
        <img src="{{asset('img/tituloBecomeapro1.png')}}" alt="titulo become a pro">
    </div>
    <br>
    <div _ngcontent-cxn-c66="" fxlayoutalign="center center" class="login-separator"
        style="place-content: center; align-items: center; flex-direction: row; box-sizing: border-box; display: flex;">
        <div _ngcontent-cxn-c66="" fxflex="" class="line-gradient-lr-primary"
            style="flex: 1 1 0%; box-sizing: border-box;"></div>
        <div _ngcontent-cxn-c66="" fxflex="" class="line-gradient-rl-primary"
            style="flex: 1 1 0%; box-sizing: border-box;"></div>
    </div>
    <div class="row justify-content-center">
        @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
            @if (Auth::user()->es_admin == 1)
            <a href="{{ url('/Admin') }}" class="btn btn-primary">Admin</a>
            @else
            <a href="{{ url('/User') }}" class="btn btn-primary">User</a>
            @endif
            @else
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
            @endif
            @endif
        </div>

        @endif
    </div>


    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</body>

</html>
