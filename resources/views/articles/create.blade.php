@extends('app')

@section('content')


    <div class="container">
        <h2>Escrever um Artigo</h2>
        <hr>
        @if ($errors->any())
            <div class="alert-danger col-lg-12">
                <ul class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {!! Form::open(['url'=>'articles/store','files' => true]) !!}

        <div class="col-sm-12">
            {!! Form::label('title','Título:') !!}
            {!! Form::text('title',null,['class'=>'form-control']) !!}
        </div>
        <br><br> <br><br>
        <div class="alert alert-info col-sm-12">
            Esta versão da aplicação encontra-se em fase de desenvolvimento. Utilize código HTML para formatar o texto.<br> Por exemplo: Se quiser colocar em
            <b>negrito</b> ou <i>itálico</i> uma parte do texto utilize <pre> &ltb&gtTexto em negrito&lt/b&gt ou &lti&gtTexto em itálico&lt/i&gt</pre>

        </div>
        <br><br>
        <div class="col-sm-12">
            {!! Form::label('body','Corpo:') !!}
            {!! Form::textarea('body',null,['class'=>'form-control','height' => '15']) !!}
        </div>


        <div class="alert alert-info col-sm-12" style="margin-top: 20px">
            O artigo só será publicado na data assinalada. Mantenha a data de hoje se <pretende></pretende>r a publicação imediata
        </div>
        <br><br> <br><br>
        <div class="col-sm-4">
            {!! Form::label('date_to_publish','Data para Publicação:') !!}
            {!! Form::text('date_to_publish', '', array('id' => 'datepicker','class'=>'form-control')) !!}
        </div>

        <div class="form-group" >
            {!! Form::submit ('Gravar',['class'=>'btn btn-primary form-control','style'=>'margin-top: 30px']) !!}
        </div>


        {!! Form::close() !!}

    </div>




    <script src="{{ asset('/js/img_preview.js') }}"></script>
    <!--DATE PICKER SCRIPT-->
    <script src="{{ asset('/js/jquery-ui_mycustom.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            //DATE PICKER
            $( "#datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true
            });
            $( "#datepicker" ).datepicker( "option", "dateFormat", "yy/mm/dd" );
            $( "#datepicker" ).datepicker( "setDate", new Date());

        });
    </script>


@endsection

