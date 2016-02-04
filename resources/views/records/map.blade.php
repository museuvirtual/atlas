@extends('app')

@section('content')
    <script src="{{ asset('/js/v3.6.0/build/ol.js') }}"></script>
    <script src="{{ asset('/js/mapa_records.js') }}"></script>

    <div class="col-md-12 text-center"><h2>Mapa de Registos</h2><h2>Atlas de {{$project}}</h2></div>

    <div class="row">
        <div class="col-md-8 col-sm-12 grid-custom map" id="map" style="height: 600px"></div>
        <div class="col-md-4" id="selected"></div>
    </div>
    <div class="container">
        <div class="row">
            <table class="table table-hover col-sm-12">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome Científico</th>
                    <th>Nome Comum</th>
                    <th>Criado em</th>
                    <th>Autor</th>
                </tr>
                </thead>
                <tbody>
                @foreach($records as $record)

                    <tr id='{{$record->id}}' onclick="selectRow({{$record->id}})">
                        <td>{{$record->record_id}}</td>
                        @if ($record->species_id)
                            <td>{{$record->species->scientific_name}} </td>
                            <td>{{$record->species->common_name_en}} </td>
                        @elseif($record->guessed_species_id)
                            <td>{{$record->guessed_species->scientific_name}} </td>
                            <td>{{$record->guessed_species->common_name_en}} </td>
                        @else
                            <td>Não Identificado</td>
                            <td>Não Identificado</td>
                        @endif
                        <td>{{$record->created_at->format('d-m-Y')}}</td>
                        <td>{{$record->user_created}} </td>
                    </tr>
                    <script>
                    createFeature(
                                {{$record->id}},
                                '{{$record->locality_name}}',
                                '{{$record->created_at->format('d-m-Y')}}',
                                {{$record->gazeteer->coordenadas($record->gazeteer->id)->lat}},
                                {{$record->gazeteer->coordenadas($record->gazeteer->id)->lon}}
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