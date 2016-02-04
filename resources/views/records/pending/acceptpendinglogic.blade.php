{!! Form::open(['url'=>'records/accept/:RECORD_ID', 'method'=> 'POST', 'id' => 'form-accept' ])!!}
{!! Form::close() !!}
{!! Form::open(['url'=>'records/reject/:RECORD_ID', 'method'=> 'POST', 'id' => 'form-reject' ])!!}
<input type="hidden" name="reasonrejected" id="reasonrejected">
{!! Form::close() !!}

<script>
    $(document).ready(function(){
        $('.btn-success').click(function(e){
            e.preventDefault();

            var id=$(this).attr('id');
            var div = $('.'+id);
            var form =$('#form-accept');
            var url= form.attr('action').replace(':RECORD_ID',id);
            var data = form.serialize();

            div.fadeOut(1000,"swing");

            $.post(url, data, function(result){
                alert(result);
            }).fail(function(){
                alert("Erro no proceso de Aceitação. Consulte o Administrador");
                div.show();
            })

        })
        $('.btn-warning').click(function(e){
            e.preventDefault();

            var id=$(this).attr('id');
            var reasonrejected=$("#reasonrejected"+id)[0].value;
            $("#reasonrejected")[0].value= reasonrejected;

            var div = $('.'+id);
            var form =$('#form-reject');
            var url= form.attr('action').replace(':RECORD_ID',id);
            var data = form.serialize();


            div.fadeOut(2000,"swing");

            $.post(url, data, function(result){
                alert(result);
            }).fail(function(){
                alert("Erro no proceso de Rejeição. Consulte o Administrador");
                div.show();
            })

        })
    })
</script>