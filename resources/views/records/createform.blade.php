<div class="row">
    <div class="col-sm-12"><h3>Passo 2: Inserir até 3 fotografias do registo</h3></div>
    <div class="alert alert-info col-sm-12">
        Pode inserir entre 1 e 3 fotografias da observação.
        Tenha em conta que todas as fotografias devem corresponder à mesma observação<br>
        As fotografias deverão estar em formato .JPG (por enquanto) e não ultrapassar 1MB de tamanho.
    </div>

</div>

<div class="row">
    <div class="col-sm-4">
        <div class="thumbnail">
            <img class="img-responsive" id="img_prev_1" src="/img/noimage.jpg">
        </div>
        <!-- image-preview-filename input -->
        <div class="input-group image-preview" id="img_1">
            <input type="text" class="form-control image-preview-filename" disabled="disabled" id="img_1">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-default image-preview-clear" style="display:none;" id="img_1">
                    <span class="glyphicon glyphicon-remove " style="color:red"></span> Apagar
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-default image-preview-input" id="img_1">
                    <span class="glyphicon glyphicon-folder-open" style="color:#00b3ee"></span>
                    <span class="image-preview-input-title" id="img_1">Buscar</span>
                    <input type="file" accept="image/jpeg,image/jpg" name="photo_1"/>
                </div>
            </span>
        </div>

    </div>
    <div class="col-sm-4">
        <div class="thumbnail">
            <img class="img-responsive" id="img_prev_2" src="/img/noimage.jpg">
        </div>
        <div class="input-group image-preview" id="img_2">
            <input type="text" class="form-control image-preview-filename" disabled="disabled" id="img_2">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-default image-preview-clear" style="display:none;" id="img_2">
                    <span class="glyphicon glyphicon-remove " style="color:red"></span> Apagar
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-default image-preview-input" id="img_2">
                    <span class="glyphicon glyphicon-folder-open" style="color:#00b3ee"></span>
                    <span class="image-preview-input-title" id="img_2">Buscar</span>
                    <input type="file" accept="image/jpeg,image/jpg" name="photo_2"/> <!-- rename it -->
                </div>
            </span>
        </div>

    </div>
    <div class="col-sm-4">
        <div class="thumbnail">
            <img class="img-responsive" id="img_prev_3" src="/img/noimage.jpg">
        </div>
        <!-- image-preview-filename input -->
        <div class="input-group image-preview" id="img_3">
            <input type="text" class="form-control image-preview-filename" disabled="disabled" id="img_3">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-default image-preview-clear" style="display:none;" id="img_3">
                    <span class="glyphicon glyphicon-remove " style="color:red"></span> Apagar
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-default image-preview-input" id="img_3">
                    <span class="glyphicon glyphicon-folder-open" style="color:#00b3ee"></span>
                    <span class="image-preview-input-title" id="img_3">Buscar</span>
                    <input type="file" accept="image/jpeg,image/jpg" name="photo_3"/> <!-- rename it -->
                </div>
            </span>
        </div>

    </div>
</div>

<div class="row">
    <hr>
</div>
<div class="row">
    <div class="col-sm-12"><h3>Passo 3: Informação da Observação</h3></div>
    <div class="alert alert-info col-sm-12">
        Preencha a seguinte informação da observação.<br>
        Se não souber ou não tiver a certeza do nome científico ou comum da espécie pode deixar o campo em branco ou tentar adivinhar.
        Posteriormente um especialista irá identificar o registo.
    </div>

</div>

<div class="row">
    <div class="form-group col-sm-12">
        {!! Form::label('date_observed','Data da Observação:',['class'=>'control-label col-sm-2']) !!}
        <div class="col-sm-4 ">
            {!! Form::text('date_observed', '', array('id' => 'datepicker','class'=>'form-control')) !!}
        </div>
    </div>
</div>

<div class="row">

    <div class="form-group col-sm-9">
        <input type="hidden" name="guessed_species_id" id="guessed_species_id">
        {!! Form::label('species_guessed','Espécie:',['class'=>'control-label col-sm-2']) !!}
        <div class="col-sm-10 ">
            {!! Form::text('species',null,['class'=>'form-control', 'id'=>'species_form']) !!}
        </div>
    </div>
    <div class="form-group col-sm-3">
        <div class="checkbox">
            <label><input type="checkbox" name="angola" id="angola" checked="true" value="1" onchange="angola_check()">
                <a href="#" data-toggle="tooltip" data-placement="auto bottom" title="Algumas especies podem ainda não estar identicadas ou catalogadas correctamente para Angola. Desmarque a caixa para ver todas as especies possiveis">
                    Ver unicamente espécies para Angola</a>
            </label>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-4">
        <input type="hidden" name="roadkill" id="roadkill" value="0">
        <div class="checkbox">
            <label><input type="checkbox" name="roadkill" value="1">
                <a href="#" data-toggle="tooltip" data-placement="auto bottom" title="Indique se o animal foi atropelado">Morto na estrada</a> <i>(roadkill)</i>
            </label>
        </div>
    </div>
    <div class="form-group col-sm-4">
        {!! Form::label('numberindividuals','Quantos indivíduos da mesma espécie há no registo?') !!}
        {!! Form::input('number', 'numberindividuals', $value = 1, $options = ['min'=>'1','class'=>'form-control','style'=>'width: 100px;'])!!}

    </div>
</div>
<div class="row">
    <div class="form-group col-sm-12">
        {!! Form::label('comment','Comentário do registo ou observação') !!}
        {!! Form::text('comment', null, $options = ['class'=>'form-control'])!!}
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-4">
        <input type="hidden" name="observer1" id="observer1" value="0">
        <div class="checkbox">
            <label><input type="checkbox" name="observer1" value="{{Auth::user()->collector_id}}" checked="true">Sou eu, {{Auth::user()->name}}, o observador deste registo</label>
        </div>
    </div>
    <div class="form-group col-sm-8">
        {!! Form::label('observer2','Outros Observadores:') !!}
        {!! Form::text('observer2',null,['class'=>'form-control', 'disabled']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('basis_of_record','Tipo de Registo:') !!}
    {!! Form::select('basis_of_record', array_pluck($basis_of_records, 'name', 'id'),null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::submit ('Gravar',['class'=>'btn btn-primary form-control']) !!}
</div>



