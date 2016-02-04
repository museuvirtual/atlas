@extends('app')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-md-9">
                <h1 style="margin-bottom: 0px">#
                    {{$specie->id}}&nbsp&nbsp&nbsp
                    <i>{{$specie->scientific_name}} </i>
                </h1>
                <h3 style="margin-top: 5px">
                    {{$specie->common_name_en}}
                </h3>
            </div>
            <div class="col-md-3" style="text-align: right">
                <h4 style="margin-top: 30px">
                    {{$specie->author_name}} ({{$specie->printed_date}})
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
            <h5>
            @foreach ($taxaitems as $item)
                @if (($specie->$item !="") OR ($specie->$item != NULL))
                    @if (($item=="species")OR($item=="subspecies")OR ($item=="genus"))
                        <i>{{$specie->$item}} </i> >
                    @else
                        {{$specie->$item}} >
                    @endif
                @endif
            @endforeach
            </h5>
            </div>

        </div>

        <div id="content" class="col-sm-6">
            <div class= "imghome">
                <div class="imgframe">
                    <h3>Species Info:</h3>
                    <hr>
                    <h5>Autoridade Taxonomica</h5>
                        <p>{{$specie->taxonomic_authority}}</p>
                    <h5>Tipo de localidade</h5>
                        <p>{!!html_entity_decode($specie->type_locality)!!}</p>
                    <h5 style="color: red">Red Data <i>Status</i></h5>
                        <p>{!!html_entity_decode($specie->red_data_status)!!}</p>
                    <h5>
                        Distribuição
                    </h5>
                    <p>{{$specie->distribution}}</p>
                    @if ($specie->angola)
                        <img src="/img/angola_flag.png" height="30px">
                    @elseif ($specie->africa)
                        <img src="/img/africa.png" height="30px">
                    @endif
                    <h5>Notas Taxonomicas</h5>
                    <p>{!!html_entity_decode($specie->taxonomic_notes)!!}</p>
                    <h5>Fonte dos Dados</h5>
                    <p>{{$specie->data_source}}</p>
                    <h5>Recon Notes</h5>
                    <p>{{$specie->recon_notes}}</p>
                    <h5>Notes</h5>
                    <p>{{$specie->notes}}</p>
                    <hr>
                    <h5>Autor</h5>
                    {{$specie->author_name}}
                    <h5>Printed Date</h5>
                    {{$specie->printed_date}}
                    <h5>True Date</h5>
                    {{$specie->true_date}}
                </div>
            </div>
        </div>

        @if (Auth::user())
            @if (Auth::user()->level>=1)

            <div id="content" class="col-sm-6">
                {!! Form::open(['url'=>'taxonomy/edit/mammal/'.$specie->id.'/distribution','class'=>'form-horizontal', 'method'=>'POST']) !!}
                <div class="imghome">
                    <h4>Edit Distribution</h4>
                    <div class="imgframe">
                        <input type="hidden" name="angola" value="0">
                        <input type="checkbox" name="angola" id="angola" value="1" onchange="check_africa_angola()">
                        {!! Form::label('angola','This species happens in Angola') !!}
                        &nbsp;&nbsp;<img src="/img/angola_flag.png" height="30px">

                    </div>
                    <div class="imgframe">
                        <input type="hidden" name="africa" value="0">
                        <input type="checkbox" name="africa" id="africa" value="1" onchange="check_africa_angola()">
                        {!! Form::label('africa','This species happens in Africa') !!}
                        &nbsp;&nbsp;<img src="/img/africa.png" height="30px">

                    </div>
                    {!! Form::submit ('Change',['class'=>'btn btn-info form-control']) !!}
                </div>
                {!! Form::close() !!}

                {!! Form::open(['url'=>'taxonomy/edit/mammal/'.$specie->id.'/common_name','class'=>'form-horizontal', 'method'=>'POST']) !!}
                <div class="imghome">
                    <h4>Edit Common Names</h4>
                    <div class="imgframe">
                        {!! Form::label('common_name_en','English Common Name') !!}
                        {!! Form::text('common_name_en', $specie->common_name_en, $options = ['class'=>'form-control'])!!}
                    </div>
                    <div class="imgframe">
                        {!! Form::label('common_name_pt','Portuguese Common Name') !!}
                        {!! Form::text('common_name_pt', $specie->common_name_pt, $options = ['class'=>'form-control'])!!}
                    </div>
                    <div class="imgframe">
                        {!! Form::label('common_name_alt','Alternative Common Names') !!}
                        {!! Form::text('common_name_alt', $specie->common_name_alt, $options = ['class'=>'form-control'])!!}
                    </div>
                    {!! Form::submit ('Change',['class'=>'btn btn-info form-control']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        @endif
    @endif

    </div> <!-- /.container -->

<script>
    $(document).ready(function(){

        if({{$specie->angola}}==1){
            $('#angola')[0].checked=true
        }else{
            $('#angola')[0].checked=false
        }
        if({{$specie->africa}}==1){
            $('#africa')[0].checked=true
        }else{
            $('#africa')[0].checked=false
        }
    });

    function check_africa_angola(){
        if ($('#angola')[0].checked==true){
            $('#africa')[0].checked=true;
        }

    };

</script>
@endsection
