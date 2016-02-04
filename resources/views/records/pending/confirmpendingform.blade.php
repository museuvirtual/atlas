<div class="row">
    <label class="control-label col-md-2">Comentários:</label>
    <div class="col-md-10">
        <input type="text" class="form-control" name="comments" id="comments{{$record->id}}">
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-8"><b>Identificação do Utilizador: </b>
        @if($record->guessed_species_id)
            <b>{{$record->guessed_species_id}}  --></b>
            <i>{{$record->guessed_species->scientific_name}} </i> -
            {{$record->guessed_species->common_name_en}}
        @else
            O utilizador não identificou a espécie
        @endif

    </div>
    <div class="col-md-2"></div>
    @if($record->guessed_species_id)
        <input type="hidden" name="guessed_sp_id" id="guessed_sp_id{{$record->id}}" value="{{$record->guessed_species_id}}">
        <button  class="btn btn-success col-md-2" id="{{$record->id}}">Confirmar Espécie</button>
    @endif

</div>
<hr>
<div class="row">
    <label class="control-label col-md-2">Nova Identificação:</label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="species_name" id="species_name{{$record->id}}">
    </div>
    <button  class="btn btn-warning col-md-2" id="{{$record->id}}">Corrigir</button>
</div>
<br>


@foreach($confirmations as $confirmation)
    @if($confirmation->mammal_record_id==$record->id)
        <hr>
        <div class="row">
            <span class="glyphicon  glyphicon-comment" style="color:saddlebrown"></span>
            by {{$confirmation->name}} {{$confirmation->surname}}
            <p><b>Espécie: </b>{{$confirmation->mammal_taxonomy_id}} -->{{$confirmation->scientific_name}} </p>
            <p><b>Comentários:</b> {{$confirmation->comments}}</p>
        </div>
    @endif
@endforeach

<script type="text/javascript">
    $(function() {

        //AUTOCOMPLETE

        $("#species_name{{$record->id}}").autocomplete({
            source: "/taxonomylist/mammal/names",
            minLength:3,
            select: function(event, ui) {
                $('#species_id').val(ui.item.id);
                $("#species_name{{$record->id}}").val(ui.item.scientific_name + " - " + ui.item.common_name_en );
                return false;
            }
        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
                    .append( "<strong><i>" + item.scientific_name + "</i></strong> - <b> " + item.common_name_en +"</b>" )
                    .appendTo( ul );
        };



    });
</script>

