@extends('app')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-md-9">
                <h1 style="margin-bottom: 0px">
                    {{$user->name}}&nbsp
                    {{$user->surname}}
                </h1>
            </div>
        </div>


        <div id="content" class="col-sm-6">
            <div class= "imghome">
                <div class="imgframe">

                    <h5><b>email</b></h5>
                    <p>{{$user->email}}</p>
                    <h5><b>Level</b></h5>
                    <p>{{$user->level}}</p>

                </div>
            </div>
        </div>

        <div id="content" class="col-sm-6">
            {!! Form::open(['url'=>'user/edit','class'=>'form-horizontal', 'method'=>'POST']) !!}

            <div class="imghome">
                <h4>Instituição</h4>
                <div class="imgframe">
                    Insituição 1
                </div>
                <div class="imgframe">
                    Insituição 1
                </div>
                {!! Form::submit ('Alterar',['class'=>'btn btn-info form-control']) !!}
            </div>
            {!! Form::close() !!}
        </div>


    </div> <!-- /.container -->

@endsection
