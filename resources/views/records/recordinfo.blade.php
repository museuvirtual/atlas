@extends('app')

@section('content')

    <div class="container">

        <div class="row">

                    <div class="col-md-8">
                        <h1 style="margin-bottom: 0px">#
                            {{$record->record_id}}&nbsp&nbsp&nbsp
                            @if ($record->species_id)
                                <i>{{$record->species->scientific_name}} </i>
                            @elseif($record->guessed_species_id)
                                <i>{{$record->guessed_species->scientific_name}} </i>
                            @else
                                Não Identificado
                            @endif
                        </h1>
                        <h3 style="margin-top: 5px">
                            @if ($record->species_id)
                                <i>{{$record->species->common_name_en}} </i
                            @elseif($record->guessed_species_id)
                                {{$record->guessed_species->common_name_en}}
                            @else
                                -
                            @endif
                        </h3>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        <h4 style="margin-top: 30px">
                            @if($record->sp_confirmed)
                                Identificação Confirmada
                                <span class="glyphicon glyphicon-ok" style="color:green"></span>
                            @else
                                Identificação Pendente de Confirmação
                                <span class="glyphicon glyphicon-question-sign" style="color:orange"></span>
                            @endif
                        </h4>
                        <h4>
                            {{$record->type_of_record->name}}&nbsp;
                            {!!html_entity_decode($record->type_of_record->glyphicon)!!}

                        </h4>
                    </div>
                </div>

                <div class="col-xs-12 imghome">
                    <div class="col-sm-12 imgframe">
                        <div id="content">
                            <div class="row">
                                @for($i = 1; $i <= $record->numPics; $i++)
                                    <div class="col-sm-4">
                                        <img src="/uploads/{{$record->id}}_{{$i}}.jpg" alt="Image" class="img-responsive img_home" data-toggle="modal" data-target="#ImageModal">
                                    </div>
                                @endfor

                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-4  grid-custom map" id="map" style="height: 300px"></div>
                                <div class="col-sm-8">
                                    <h4><b>Local de observação:</b> {{$record->gazeteer->locality_name}}</h4>
                                    <h4><b>Municipio:</b> {{$record->gazeteer->province->municipe}}</h4>
                                    <h4><b>Provincia:</b> {{$record->gazeteer->province->province}}</h4>
                                </div>
                                <hr>
                                <div class="col-sm-8">
                                    <h4><b>Registo Submetido por:</b>  {{$record->created_by->name}} {{$record->created_by->surname}}
                                    em: {{$record->created_at->format('d-m-Y')}}</h4>
                                </div>
                                <div class="col-sm-8">
                                   <h4> <b>Observadores:</b>
                                    @foreach($record->collectors as $collector)
                                        {{$collector->name}} {{$collector->surname}}&nbsp &nbsp
                                    @endforeach
                                    </h4>
                                </div>
                                <div class="col-sm-8">
                                    <h4><b>Data de Observação:</b> {{$record->date_observed->format('d-m-Y')}}</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="aditionalinfo">
                                    <div class="col-md-4 col-sm-12">
                                        <div><h4>Outras observações próximas <a href="#">+</a> </h4></div>
                                        @foreach ($closest_records as $rec)
                                            <div class="col-sm-6 thumb imghome">
                                                <div class="col-sm-12 imgframe">
                                                    <a href="{{ url('/records/'.$rec->id) }}">
                                                        <img class="img-responsive" src="/uploads/{{$rec->id}}_1.jpg">
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    @if ($same_species_records)
                                            <div class="col-md-4 col-sm-12">
                                                <h4>Outras observações da mesma espécie <a href="#">+</a></h4>
                                                @foreach ($same_species_records as $rec)
                                                    <div class="thumb imghome col-sm-6">
                                                        <div class="col-sm-12 imgframe">
                                                            <a href="{{ url('/records/'.$rec->id) }}">
                                                                <img class="img-responsive" src="/uploads/{{$rec->id}}_1.jpg">
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                    @endif
                                    @if ($same_author_records)
                                        <div class="col-md-4 col-sm-12">
                                            <h4>Outras observações do mesmo autor <a href="#">+</a></h4>
                                            @foreach ($same_author_records as $rec)
                                               <div class="thumb imghome col-sm-6">
                                                   <div class="col-sm-12 imgframe">
                                                       <a href="{{ url('/records/'.$rec->id) }}">
                                                           <img class= "img-responsive" src="/uploads/{{$rec->id}}_1.jpg">
                                                       </a>
                                                   </div>
                                               </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    </div>
                                </div>
                            <hr>
                            <div class="row">
                                <h2><span class="glyphicon  glyphicon-comment" style="color:saddlebrown"></span> Comentários dos Especialistas</h2>
                                @foreach($confirmations as $confirmation)
                                    @if($confirmation->mammal_record_id==$record->id)
                                        <hr>
                                        <div class="row">
                                            <span class="glyphicon  glyphicon-comment" style="color:#006400"></span>
                                            by {{$confirmation->name}} {{$confirmation->surname}}
                                            <p><b>Confirmação da espécie:</b> {{$confirmation->scientific_name}} </p>
                                            <p><b>Comentários:</b> {{$confirmation->comments}}</p>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                     </div>
                </div>
        </div> <!-- /.row -->

    </div> <!-- /.container -->

    <script src="{{ asset('/js/imagesloaded.3.1.8.min.js') }}"></script>
    <script>
        var $container=null;
        function init_masonry(){
            $container = $('#content');

            $container.imagesLoaded( function(){
                $container.masonry({
                    itemSelector: '.infos',
                    isAnimated: true
                });
            });

        }
        $( document ).ready( function(){
            init_masonry();
        });
    </script>
    <script src="{{ asset('/js/v3.6.0/build/ol.js') }}"></script>
    <script src="{{ asset('/js/mapa_rec_info.js') }}"></script>
    <script>createFeature(
                {{$record->gazeteer->id}},
                {{$record->gazeteer->coordenadas($record->gazeteer->id)->lat}},
                {{$record->gazeteer->coordenadas($record->gazeteer->id)->lon}}
        )
        loadMap ();
        loadFeaturesToMap();
    </script>

@endsection
