@extends('app')

@section('content')



    <div class="container">
        <h2>Criar um Novo Local de Observação</h2>
        <hr>
         @include('gazeteer.createform')
        <script>loadMap();</script>

    </div>

@endsection