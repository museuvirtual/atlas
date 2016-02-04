@extends('app')

@section('content')
    <div class="panel-heading">Registos do Observador:  {{$collector->name}}<nbsp></nbsp>{{$collector->surname}}</div>


    @foreach($collector->mammalrecords as $record)
        <div class="panel-body">
            <h4>Numero:{{$record->id}}</h4>
            <p>Criado por: {{$record->created_by->name}}</p>
            <p>Criado em: {{$record->created_at}}</p>
            <p>Num Pics: {{$record->numPics}}</p>
            <p>Observador/es:@foreach($record->collectors as $collector)
                    {{$collector->name}}<nbsp></nbsp>


                @endforeach</p>

        </div>
    @endforeach
@endsection
