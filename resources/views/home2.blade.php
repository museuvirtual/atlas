@extends('app')

@section('content')

    <div class="container">
        <div class="col-md-12">

            <div class="well">
                <div id="myCarousel" class="carousel slide">

                    <!-- Carousel items -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="row">
                                @for($i=0; $i<4; $i++)

                                    <div class="col-sm-3"><a href="/records/{{$lastRecords[$i]->id}}"><img src="/uploads/{{$lastRecords[$i]->id}}_1.jpg" alt="Image" class="img-responsive"></a>
                                    </div>
                                @endfor

                            </div>
                            <!--/row-->
                        </div>
                        <!--/item-->
                        <div class="item">
                            <div class="row">
                                <div class="col-sm-3"><a href="#x" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                                </div>
                                <div class="col-sm-3"><a href="#x" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                                </div>
                                <div class="col-sm-3"><a href="#x" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                                </div>
                                <div class="col-sm-3"><a href="#x" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                                </div>
                            </div>
                            <!--/row-->
                        </div>

                    </div>
                    <!--/carousel-inner--> <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>

                    <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
                </div>
                <!--/myCarousel-->
            </div>
            <!--/well-->
        </div>
    </div>


    <!-- Script to Activate the Carousel -->
    <script>
        $(document).ready(function() {
            $('#myCarousel').carousel({
                interval: 10000
            })

            $('#myCarousel').on('slid.bs.carousel', function() {
                //alert("slid");
            });


        });
    </script>

@endsection
