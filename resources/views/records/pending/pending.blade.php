@extends('app')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{$title}}</h1>
            </div>
            <div class="col-lg-6">
                <h4>Todos os Registos: {{$pendingrecords->count()}}</h4>
            </div>


        </div>


        <hr>


        <div id="content">
                @foreach($pendingrecords as $record)

                    <div class="col-md-12  thumb imghome {{$record->id}}" >
                        <div class="col-md-12 imgframe">
                            <div class="col-md-3">
                                <span style="font-size: small">
                                    <div class ="col-md-12" style="padding-left:0">
                                        <b>#{{$record->id}}</b>
                                    </div>
                                    <div class ="col-md-12" style="padding-left:0">
                                        Common Name: <b>
                                            @if($record->guessed_species_id)
                                                {{$record->guessed_species->common_name_en}}
                                            @else
                                                Não identificado
                                            @endif </b>
                                    </div>
                                    <div class ="col-md-12" style="padding-left:0">
                                        Sc. Name: <b>
                                            @if($record->guessed_species_id)
                                                <i>{{$record->guessed_species->scientific_name}} </i>
                                            @else
                                                Não Identificado
                                            @endif </b>
                                    </div>
                                    <div class ="col-md-12" style="padding-left:0">
                                        Created by: <b>{{$record->created_by->name}}</b><br>
                                    </div>
                                    <span style="font-size: small">Observador/es:
                                        @foreach($record->collectors as $collector)
                                            <b>{{$collector->name}}</b>&nbsp &nbsp
                                        @endforeach
                                     </span>
                                    <div class ="col-md-12" style="padding-left:0">
                                        Created at:
                                        <b>{{$record->created_at->format('d-m-Y')}}</b>
                                    </div>

                                    <div class ="col-md-12" style="padding-left:0">
                                        <span class="glyphicon glyphicon-globe"></span>
                                        <b>{{$record->gazeteer->locality_name}}</b>
                                    </div>

                                    <div class ="col-md-12" style="padding-left:0">
                                        Observed at:
                                        <b>{{$record->date_observed->format('d-m-Y')}}</b>
                                    </div>
                                </span>

                            </div>

                            @for($i = 1; $i <= 3; $i++)
                                <div class="col-md-3">
                                    @if (file_exists('uploads/'.$record->id.'_'.$i.'.jpg'))
                                        <img src="/uploads/{{$record->id}}_{{$i}}.jpg"
                                             alt="Image" class="img-responsive img_home"
                                             data-toggle="modal" data-target="#ImageModal" />
                                    @endif
                                </div>
                            @endfor

                            <div class="col-md-12"><hr></div>
                            <div class="col-md-12">
                                @if($mode=="accept")
                                    @include('records.pending.acceptpendingform')
                                @endif
                                @if($mode=="confirm")
                                    <script src="{{ asset('/js/jquery-ui_mycustom.min.js') }}"></script>
                                    @include('records.pending.confirmpendingform')
                                @endif
                                @if($mode=="rejected")
                                    @include('records.pending.rejectedform')
                                @endif

                            </div>


                        </div>
                    </div>
                @endforeach
            </div>

    </div> <!-- /.container -->


    @if($mode=="accept")
        @include('records.pending.acceptpendinglogic')
    @endif
    @if($mode=="confirm")
        @include('records.pending.confirmpendinglogic')
    @endif

@endsection
