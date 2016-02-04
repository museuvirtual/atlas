@extends('app')

@section('content')


        @if (Auth::guest())
            <p style="text-align: center"> <span class="glyphicon glyphicon-info-sign" style="font-size:xx-large ;color:firebrick"></span>
            Bem-Vindo ao Museu Virtual de Biodiversidade de Angola. Para submeter registos e poder aceder a
                todas as funcionalidades do museu faça <a href="{{url("auth/login")}}">login</a> com o seu utilizador ou se ainda não tiver um, <a href="{{url("auth/register")}}">registe-se agora<a/>.</p>
        @endif

        <div id="content">

            @foreach($lastRecords as $i)

                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 imghome3" style="padding: 0">
                    <div class="col-sm-12 img_home3" style="padding: 0" >
                        <a href="/records/{{$i->id}}">
                            <img src="/uploads/{{$i->id}}_1.jpg" alt="Image" class="img-responsive img_home">
                        </a>
                    </div>
                </div>
            @endforeach
        </div>


    <script src="{{ asset('/js/imagesloaded.3.1.8.min.js') }}"></script>
    <script>

        var $container=null;
        function init_masonry(){
            $container = $('#content');

            $container.imagesLoaded( function(){
                $container.masonry({
                    itemSelector: '.imghome3',
                    isAnimated: true
                });
            });

        }
        $( document ).ready( function(){
            init_masonry();
        });
    </script>


@endsection
