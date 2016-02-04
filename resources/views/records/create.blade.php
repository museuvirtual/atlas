@extends('app')

@section('content')


<div class="container">
    <h2>Criar um Novo Registo de Observação</h2>
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
    <div class="row">
        <div class="col-sm-12"><h3>Passo 1: Localização do Registo</h3></div>
        <div class="alert alert-info col-sm-12">Registe o local onde tirou as fotografias. Este local será guardado no seu gazeteer pessoal e poderá voltar a ser utilizado em futuros registos</div>
        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-info col-sm-2 col-sm-offset-5" data-toggle="modal" data-target="#GazModal">Registar Novo Local</button>
        <!--<button type="button" class="btn btn-info col-sm-2" data-toggle="collapse" data-target="#reg_gaz">Registar Novo Local</button>-->
    </div>
    <br>
    <!-- Modal -->
    <div id="GazModal" class="modal fade" role="dialog">
        <div id="GazModal_" class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Registar um Novo Local</h4>
                </div>
                <div class="modal-body">
                    @include('gazeteer.createform')

                    <script>
                        $('#GazModal').on('shown.bs.modal', function () {
                            if ($.type(mapgaz)=="string")
                                loadMap();
                    })
                    </script>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="alert alert-info col-sm-12">
            Se já gravou o local onde tirou as fotografias anteriormente, pode escolhê-lo entre os registos do seu gazeteer
        </div>
    </div>

    {!! Form::open(['url'=>'records/create','files' => true]) !!}
    <div class="row">
        <div class="form-group col-sm-4 col-sm-offset-4">
            {!! Form::select('localidades', array_pluck($localidades, 'locality_name', 'id'),null,['class'=>'form-control']) !!}
        </div>
    </div>
    <hr>

    <div class="col-sm-12">
        @include('records.createform')
    </div>
        {!! Form::close() !!}

    </div>

</div>


<script src="{{ asset('/js/img_preview.js') }}"></script>
<!--DATE PICKER SCRIPT-->
<script src="{{ asset('/js/jquery-ui_mycustom.min.js') }}"></script>
<script type="text/javascript">

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

    // angola_check() Ativado quando o checkbox de Angola muda.
    // Muda o valor de source do autocomplete segundo seja para procurar unicamente por taxa de angola ou nao
    function angola_check(){
        if ($('#angola')[0].checked==true){
            $("#species_form").autocomplete({source:"/taxonomylist/mammal/names?angola=1"});
        }
        else{
            $("#species_form").autocomplete({source:"/taxonomylist/mammal/names?angola=0"});
        }
    }
    $(function() {
        //DATE PICKER
        $( "#datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
        $( "#datepicker" ).datepicker( "option", "dateFormat", "yy/mm/dd" );

        //Variavel angola que checka se a caixa esta checked para enviar parametro angola al autocomplete


        $("#species_form").autocomplete({
            source: "/taxonomylist/mammal/names?angola=1",
            minLength:3,
            select: function(event, ui) {
                $('#guessed_species_id').val(ui.item.id);
                $('#species_form').val(ui.item.scientific_name + " - " + ui.item.common_name_en );
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

