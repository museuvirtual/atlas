@extends('app')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-header">{{$title}}</h1>
            </div>

            <div class="col-sm-6">
                <h4>Todos os Registos: {{$records->total()}}</h4>
                {!! $records->render() !!}
            </div>
            <div class="col-sm-6 btn btn-info" href="#pesquisa" data-toggle="collapse">
                Pesquisa Avançada
            </div>

        </div>

        <div class="collapse" id="pesquisa">
            {!! Form::open(['url'=>'records','class'=>'form-horizontal', 'method'=>'GET']) !!}
            <div class="container">
                <div class="row">
                    <div class="col-sm-2" style="background-color: sandybrown; border-radius: 5px;padding: 3px;">
                        <p align="center"><b>Propriedades do Registo</b></p>
                    </div>
                    <div class="col-sm-2" style="background-color: sandybrown; border-radius: 5px;padding: 3px; margin-left: 5px">
                        <p align="center"><b>Data da observação</b></p>
                    </div>
                    <div class="col-sm-3" style="background-color: sandybrown; border-radius: 5px;padding: 3px; margin-left: 5px">
                        <p align="center"><b>Espécie</b></p>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-2">

                        {!! Form::label('basis_of_record_id','Tipo de Registo') !!}
                        {!! Form::select('basis_of_record_id', array_pluck($basis_of_records, 'name', 'id'),null,['class'=>'form-control']) !!}
                        <hr>
                        {!! Form::label('identity_confirmed','Identificação Confirmada') !!}
                        <select name="sp_confirmed" class="form-control">
                            <option value="">...</option>
                            <option value="2">TOTALMENTE CONFIRMADA</option>
                            <option value="1">PARCIALMENTE CONFIRMADA</option>
                            <option value="0">SEM CONFIRMAR</option>
                        </select>

                    </div>
                    <div class="col-sm-2" style="margin-left: 5px">

                        {!! Form::label('date_observed_min','Depois de:') !!}
                        {!! Form::text('date_observed_min', '', array('class'=>'form-control datepicker')) !!}
                        <hr>
                        {!! Form::label('date_observed_max','Antes de:') !!}
                        {!! Form::text('date_observed_max', '', array('class'=>'form-control datepicker')) !!}
                    </div>

                    <div class="col-sm-3" style="margin-left: 5px">

                        {!! Form::label('species_name','Nome Científico ou Comum:') !!}
                        {!! Form::text('species_name',null,['class'=>'form-control']) !!}
                        <input type="hidden" name="species_id" id="species_id"/>
                        <hr>

                    </div>

                </div>
                <br>
                <div class="col-sm-3">  {!! Form::submit ('Pesquisa',['class'=>'btn btn-info form-control']) !!}</div>
            </div>
            {!! Form::close() !!}

        </div>

        <hr>


        <div id="content">
                @foreach($records as $record)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 thumb imghome">
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
                                <span style="font-size: small">{{$record->date_observed->format('d-m-Y')}}</span>
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

        <div style="text-align: center;">
            <div style="display: inline-block; ">
                {!! $records->render() !!}
            </div>
        </div>


    </div> <!-- /.container -->

    <script src="{{ asset('/js/imagesloaded.3.1.8.min.js') }}"></script>
    <script>

        var $container=null;
        function init_masonry(){
            $container = $('#content');

            $container.imagesLoaded( function(){
                $container.masonry({
                    itemSelector: '.imghome',
                    isAnimated: true
                });
            });

        }
        $( document ).ready( function(){
            init_masonry();
        });
    </script>
    <script src="{{ asset('/js/jquery-ui_mycustom.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $( ".datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true
            });
            $( ".datepicker" ).datepicker( "option", "dateFormat", "dd-mm-yy" );

            //AUTOCOMPLETE

            $("#species_name").autocomplete({
                source: "/taxonomylist/mammal/records",
                minLength:3,
                select: function(event, ui) {
                    $('#species_id').val(ui.item.id);
                    $('#species_name').val(ui.item.scientific_name + " - " + ui.item.common_name_en );
                    return false;
                }
            }).autocomplete( "instance" )._renderItem = function( ul, item ) {
                return $( "<li>" )
                        .append( "<strong><i>" + item.scientific_name + "</i></strong> - <b> " + item.common_name_en +"</b>" )
                        .appendTo( ul );
            };

        });
    </script>

@endsection
