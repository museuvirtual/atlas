@extends('app')

@section('content')


    <div class="row">
        <div class="col-sm-12" style="text-align:center">
            <h2>Taxonomia - {{$group}} - {{$order}} - ({{$species_list->total()}})</h2>
            @if ($angola)
                <h3>Angola</h3>
            @elseif($africa)
                <h3>Africa</h3>
            @else
                <h3>World</h3>
            @endif
        </div>

    </div>
    <div class="container">

        <div class="col-sm-12 alert alert-info">Escolha uma Ordem para visualizar a taxonomia</div>
        {!! Form::open(['url'=>'taxonomylist/mammal','class'=>'form-horizontal', 'method'=>'GET']) !!}
        <div class="row">
            <div class="col-sm-3">
                <input type="hidden" name="africa" value="0">
                <input type="checkbox" name="africa" id="africa" value="1">
                {!! Form::label('africa','Mostrar Taxonomia para África') !!}
                <br>
                <input type="hidden" name="angola" value="0">
                <input type="checkbox" name="angola" id="angola" value="1">
                {!! Form::label('angola','Mostrar Taxonomia para Angola') !!}
            </div>

            <div class="col-sm-4">
                {!! Form::label('order','Order') !!}
                {!! Form::select('order', array_pluck($orderlist, 'order', 'order'),'All',['id'=>'order','class'=>'form-control']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">

            </div>
            <div class="col-sm-1">


            </div>
        </div>


        <hr>

        <div class="col-sm-4">
            {!! Form::submit ('Listar',['class'=>'btn btn-info form-control']) !!}
        </div>
        {!! Form::close() !!}
        <hr>
    </div>

    <div class="container">

        <!--inclui na url gerada pelo paginator os parametros order, angola e africa-->
        {!! $species_list->appends(['order' => $order,'angola'=>$angola,'africa'=>$africa])->render() !!}
        <div class="row">
            <table class="table table-hover col-sm-12">
                <thead>
                <tr>

                    <th>Id</th>
                    <th>Nome Comum Inglês</th>
                    <th>Order</th>
                    <th>Family</th>
                    <th>Genus</th>
                    <th>Species</th>
                    <th>Subspecies</th>
                    <th>Author</th>
                    <th>Distrib</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @foreach($species_list as $species)


                    <tr id='{{$species->id}}' onclick="selectRow({{$species->id}})">
                        <td>{{$species->id}}</td>
                        <td>{{$species->common_name_en}}</td>
                        <td>{{$species->order}}</td>
                        <td>{{$species->family}}</td>
                        <td>{{$species->genus}} </td>
                        <td>{{$species->species}} </td>
                        <td>{{$species->subspecies}} </td>
                        <td>{{$species->author_name}} ({{$species->printed_date}}) </td>
                        <td>
                            @if ($species->angola)
                                <img src="/img/angola_flag.png" height="30px">
                            @elseif ($species->africa)
                                <img src="/img/africa.png" height="30px">
                            @endif
                        </td>
                        <td><a href="/taxonomy/{{$species->id}}">+info/edit</a> </td>
                    </tr>

                @endforeach

                </tbody>
            </table>

        </div>

    </div>
    <script>
        $(document).ready(function(){

            if({{$angola}}==1){
                $('#angola')[0].checked=true
            }else{
                $('#angola')[0].checked=false
            }
            if({{$africa}}==1){
                $('#africa')[0].checked=true
            }else{
                $('#africa')[0].checked=false
            }

            $("[value={{$order}}]")[0].setAttribute("selected","True")


        })
        function selectRow(id){

            $('[class="success"]').attr("class","");
            $("#"+id).attr("class","success");
        };
    </script>
@endsection