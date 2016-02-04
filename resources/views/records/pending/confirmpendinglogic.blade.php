{!! Form::open(['url'=>'records/confirm/:RECORD_ID', 'method'=> 'POST', 'id' => 'form-confirm' ])!!}
<input type="hidden" name="comments" id="comments">
<input type="hidden" name="species_id" id="species_id">
{!! Form::close() !!}

<script>
    $(document).ready(function(){
        $('.btn-success').click(function(e){
            e.preventDefault();

            var id=$(this).attr('id');
            var comment=$('#comments'+id).val();
            $("#comments").val(comment);

            var sp_id=$('#guessed_sp_id'+id).val();
            $("#species_id").val(sp_id);

            var div = $('.'+id);
            var form =$('#form-confirm');
            var url= form.attr('action').replace(':RECORD_ID',id);
            var data = form.serialize();

            div.fadeOut(1000,"swing");

            $.post(url, data, function(result){
                alert(result);
            }).fail(function(){
                alert("Erro no proceso de Confirmação. Consulte o Administrador");
                div.show();
            })

        })
        $('.btn-warning').click(function(e){
            e.preventDefault();

            var id=$(this).attr('id');
            var comment=$('#comments'+id).val();
            $("#comments").val(comment);

            var div = $('.'+id);
            var form =$('#form-confirm');
            var url= form.attr('action').replace(':RECORD_ID',id);
            var data = form.serialize();

            div.fadeOut(1000,"swing");

            $.post(url, data, function(result){
                alert(result);
            }).fail(function(){
                alert("Erro no proceso de Confirmação. Consulte o Administrador");
                div.show();
            })

        })
    })
</script>