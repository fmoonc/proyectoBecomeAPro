@extends('layouts.app')
@section('content')
<div class="container">
    <div class="text-center">
        <h2 class="white">Seguimiento de cuenta</h2>
        <p>Become a pro es una herramienta que actua sobre las estadísticas de league of legends
            permitiendo víncular una cuenta propia para hacer el seguimiento de los resultados de esta cuenta,
            pero a su vez permite vincular una cuenta ajena de un jugador más experto para ver cuales son sus
            estadísticas y así poder copiar sus puntos fuertes.
        </p>
        @if (Session::has('invocador'))

        <div class="alert alert-danger" role="alert">
            {{session('invocador')}}
        </div>

        @endif


        <vincular-component />


    </div>
</div>
<!--
<div _ngcontent-cxn-c66="" fxlayoutalign="center center" class="login-separator"
    style="place-content: center; align-items: center; flex-direction: row; box-sizing: border-box; display: flex;">
    <div _ngcontent-cxn-c66="" fxflex="" class="line-gradient-lr-primary" style="flex: 1 1 0%; box-sizing: border-box;">
    </div>
    <span>o</span>
    <div _ngcontent-cxn-c66="" fxflex="" class="line-gradient-rl-primary" style="flex: 1 1 0%; box-sizing: border-box;">
    </div>
</div>
<div class="container">
    <div class="text-center">
        <h2 class="white">Accede a tus cuentas</h2>
        <p>Puedes acceder de una manera rapida a la vista general de las cuentas vinculadas
        </p>
        <mostrar-cuentas-component />
 -->

</div>
</div>

@endsection
