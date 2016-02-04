@extends('app')

@section('content')




    <div id="content">
        <div class="col-md-3  xs-6">

            <div style="text-align: center;">
                <div style="display: inline-block; ">
                    <h4>Últimos Registos</h4>
                </div>
            </div>
            @foreach($lastRecords as $record)

                <div class="col-xs-12 thumb imghome">
                    <div class="col-sm-12 imgframe">
                        <div class ="col-xs-10" style="padding-left:0">
                            @if($record->sp_confirmed)
                                <span class="glyphicon glyphicon-ok" style="color:green;float: left; padding-right: 4px"></span>
                            @else
                                <span class="glyphicon glyphicon-question-sign" style="color:orange;float: left;padding-right: 4px"></span>
                            @endif

                            @if ($record->species_id)
                                <b>{{$record->species->scientific_name}}</b>
                            @elseif($record->guessed_species_id)
                                @if ($record->guessed_species->common_name_en!="")
                                    <b>{{$record->guessed_species->common_name_en}}</b>
                                @else
                                    <b>{{$record->guessed_species->scientific_name}}</b>
                                @endif
                            @else
                                <b>Sem Identificar</b>
                            @endif
                        </div>
                        <div class ="col-xs-2" style="padding-right:0; float: right">
                            <b>#{{$record->record_id}}</b>
                        </div>
                        <div class ="col-xs-4" style="padding-left:0">
                            <span style="font-size: small">{{$record->created_by->name}}</span><br>
                            <span style="font-size: small">{{$record->created_at->format('d-m-Y')}}</span>
                        </div>
                        <div class ="col-xs-8" style="text-align: right; padding-right: 0">
                            <span style="font-size: small; padding-right: 0">{{$record->gazeteer->province->municipe}}, {{$record->gazeteer->province->province}}</span>
                            <span class="glyphicon glyphicon-globe"></span>
                        </div>



                        <br>
                        <br> </p>
                        <a class="col-xs-12" style="padding-left:0; padding-right: 0" href="{{ url('/records/'.$record->id) }}">
                            @if (file_exists('uploads/'.$record->id.'_1.jpg'))
                                <img class="img-responsive" src="/uploads/{{$record->id}}_1.jpg">
                            @else
                                <img class="img-responsive" src="/img/noimage.jpg">
                            @endif
                        </a>
                        <div class="col-xs-9" style="padding-left:0"><span style="font-size: x-small">Observador/es:
                                @foreach($record->collectors as $collector)
                                    {{$collector->name}}&nbsp &nbsp
                                @endforeach
                                     </span>
                        </div>
                        <div class="col-xs-3" style=" padding-right: 0;float: right">
                            {!!html_entity_decode($record->type_of_record->glyphicon)!!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-md-7">

            @foreach($fixedArticles as $article)
                <div class="col-xs-12 imghome">
                    <h3 style="margin-bottom: 5px">{{$article->title}}</h3>
                    <h5 style="margin-top: 5px">{{$article->user_created->name}} {{$article->user_created->surname}} </h5>
                    <div class="col-sm-12 imgframe">
                        {{$article->text}}
                        <br><br>
                    </div>
                    <h5 style="text-align: right">{{$article->date_to_publish->format('d-m-Y')}}</h5>
                </div>
            @endforeach

            @foreach($lastArticles as $article)
                <div class="col-xs-12 imghome">
                    <h3 style="margin-bottom: 5px">{{$article->title}}</h3>
                    <h5 style="margin-top: 5px">{{$article->user_created->name}} {{$article->user_created->surname}} </h5>
                    <div class="col-sm-12 imgframe">
                        {{$article->text}}
                        <br><br>
                    </div>
                    <h5 style="text-align: right">{{$article->date_to_publish->format('d-m-Y')}}</h5>
                </div>
            @endforeach
        </div>
        <div class="col-md-2">
            <h4>Tutorial <span style="font-size: small">(proximamente)</span></h4>
            <p>Como submeto um registo?</p>
            <p>Como visualizo os registos existentes?</p>

        </div>
    </div>


    <script src="{{ asset('/js/imagesloaded.3.1.8.min.js') }}"></script>
    <script>

        var $container=null;
        function init_masonry(){
            $container = $('#content');

            $container.imagesLoaded( function(){
                $container.masonry({
                    itemSelector: '.imghome3',
                    isAnimated: true
                });
            });

        }
        $( document ).ready( function(){
            init_masonry();
        });
    </script>


@endsection
