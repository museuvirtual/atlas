<script src="{{ asset('/js/v3.6.0/build/ol.js') }}"></script>


@if ($errors->any())
    <div class="row">
        <ul class="alert alert-danger col-sm-12">
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach

        </ul>
    </div>
@endif
{!! Form::open(['url'=>'gazeteer/create','class'=>'form-horizontal']) !!}

{!! Form::hidden('originPath', Request::path()) !!}


<div class="alert alert-info">
    O nome da localidade deverá ser único. Se quiser inserir várias localidades com o mesmo nome pode colocar um número
    ou identificador no final do nome. Por exemplo: "P.N. do Bicuar - 2", "P.N. Bicuar - Entrada Norte", "P.N. Bicuar - NE"
</div>
<div class="row">
    <div class="form-group">
        {!! Form::label('locality_name','Localidade/Referência do Local:',['class' => 'control-label col-sm-3']) !!}
        <div class="col-sm-5">
            {!! Form::text('locality_name',null,['class'=>'form-control']) !!}
        </div>

    </div>
</div>
<div class="alert alert-info">
    As coordenadas devem ser inseridas no formato Graus - Minutos - Segundos. Por exemplo 15º 20' 34''
    <br>Se desconhece as coordenadas, também pode seleccionar um ponto no mapa
</div>

<div class="form-group col-sm-8">
    <div class="col-sm-3" style="vert-align: center"><b>Latitude</b></div>
    <div class="col-sm-2">
        <div>&nbsp</div>
        <div id="hemisferio_lat"></div>
    </div>
    <div class="col-sm-2">
        {!! Form::label('latitude_deg','Graus:') !!}
        {!! Form::text('latitude_deg',null,['class'=>'form-control']) !!}
    </div>
    <div class="col-sm-2">
        {!! Form::label('latitude_min','Minutos:') !!}
        {!! Form::text('latitude_min',null,['class'=>'form-control']) !!}
    </div>
    <div class="col-sm-2">
        {!! Form::label('latitude_sec','Segundos:') !!}
        {!! Form::text('latitude_sec',null,['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group col-sm-4 grid-custom">
    <div><b>Província:</b></div>
    <div id="province_div"></div>
</div>
<div class="form-group col-sm-8">
    <div class="col-sm-3" style="vert-align: center"><b>Longitude</b></div>
    <div class="col-sm-2">
        <div>&nbsp</div>
        <div id="hemisferio_long"></div>
    </div>
    <div class="col-sm-2">
        {!! Form::label('longitude_deg','Graus:') !!}
        {!! Form::text('longitude_deg',null,['class'=>'form-control']) !!}
    </div>
    <div class="col-sm-2">
        {!! Form::label('longitude_min','Minutos:') !!}
        {!! Form::text('longitude_min',null,['class'=>'form-control']) !!}
    </div>
    <div class="col-sm-2">
        {!! Form::label('longitude_sec','Segundos:') !!}
        {!! Form::text('longitude_sec',null,['class'=>'form-control']) !!}
    </div>

</div>

<div class="form-group col-sm-4 grid-custom">
    <div><b>Município:</b></div>
    <div id="municipe_div"></div>
</div>

<div class="row">

    <div class="col-sm-8 grid-custom map" id="map" style="height: 350px; background-color:white">
        <div id="olmap" class="fill"></div>
    </div>
    <div id="popup" class="ol-popup">
        <a href="#" id="popup-closer" class="ol-popup-closer"></a>
        <div id="popup-content"></div>
    </div>


    <div id="info"></div>

    <div class="col-sm-4 grid-custom" id="mouse-position">
            &nbsp;
    </div>
    <div class="col-sm-4 grid-custom" id="select_map_source">
        &nbsp;&nbsp; Seleccionar Mapa Base:
        <br>
        <select id="layer-select">
            <option value="Aerial">Bing Aerial</option>
            <option value="AerialWithLabels" selected>Bing Aerial with labels</option>
            <option value="Road">Bing Roads</option>
        </select>
    </div>
</div>

<br>
<div class="row">
    <div class="form-group col-sm-4">
        {!! Form::label('locality_nature_id','Natureza da localidade:',['class' => 'control-label col-sm-6']) !!}
        <div class="col-sm-6">
            {!! Form::select('locality_nature_id', array_pluck($locality_natures, 'nature', 'id'),null,['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="form-group col-sm-4">
        {!! Form::label('coords_source_id','Origem das Coordenadas:',['class' => 'control-label col-sm-6']) !!}
        <div class="col-sm-6">
            {!! Form::select('coords_source_id', array_pluck($coords_sources, 'source', 'id'),null,['class'=>'form-control']) !!}
        </div>
    </div>
</div>
<hr>





<div class="form-group">
    {!! Form::label('locality_name_alt','Nome alternativo da localidade:',['class' => 'control-label col-sm-2']) !!}
    <div class="col-sm-4">
        {!! Form::text('locality_name_alt',null,['class'=>'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('closest_town','Cidade, Vila mais próxima:',['class' => 'control-label col-sm-2']) !!}
    <div class="col-sm-4">
        {!! Form::text('closest_town',null,['class'=>'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('locality_description','Descrição adicional:',['class' => 'control-label col-sm-2']) !!}
    <div class="col-sm-10">
        {!! Form::text('locality_description',null,['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('locality_notes','Comentários Localidade:',['class' => 'control-label col-sm-2']) !!}
    <div class="col-sm-10">
        {!! Form::text('locality_notes',null,['class'=>'form-control']) !!}
    </div>
</div>




<div class="form-group col-sm-2">
    {!! Form::submit ('Gravar',['class'=>'btn btn-primary form-control']) !!}
</div>

{!! Form::close() !!}


<script src="{{ asset('/js/mapa_gaz_create.js') }}"></script>