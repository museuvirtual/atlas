@extends('app')

@section('content')
    <script src="{{ asset('/js/v3.6.0/build/ol.js') }}"></script>
    <script src="{{ asset('/js/mapa_gaz_show.js') }}"></script>

    <div class="col-md-12"><h2>Registos Gazeteer</h2></div>

    <div class="row">
        <div class="col-md-8 col-sm-12 grid-custom map" id="map" style="height: 350px"></div>
        <div class="col-md-4" id="selected"></div>
    </div>
<div class="container">
    <div class="row">
        <table class="table table-hover col-sm-12">
            <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Criado em</th>
                <th>Longitude</th>
                <th>Latitude</th>
            </tr>
            </thead>
            <tbody>
                @foreach($records as $record)

                    <tr id='{{$record->id}}' onclick="selectRow({{$record->id}})">
                        <td>{{$record->id}}</td>
                        <td>{{$record->locality_name}}</td>
                        <td>{{$record->created_at->format('d-m-Y')}}</td>
                        <td>{{$record->coordenadas($record->id)->lon}}</td>
                        <td>{{$record->coordenadas($record->id)->lat}} </td>
                    </tr>
                    <script>createFeature(
                                {{$record->id}},
                                '{{$record->locality_name}}',
                                '{{$record->created_at->format('d-m-Y')}}',
                                {{$record->coordenadas($record->id)->lat}},
                                {{$record->coordenadas($record->id)->lon}}
                        )
                    </script>
                @endforeach

            </tbody>
        </table>

    </div>

    <script>
        loadMap ();
        loadFeaturesToMap();
    </script>
</div>
@endsection