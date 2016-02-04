<button  class="btn btn-success col-md-1" id="{{$record->id}}">Aceitar</button>
<div class="col-md-3"></div>
<label class="control-label col-md-1">Motivo Rejeição:</label>
<div class="col-md-6">
    <input type="text" class="form-control" name="motivo" id="reasonrejected{{$record->id}}">
</div>
<button  class="btn btn-warning col-md-1" id="{{$record->id}}">Rejeitar</button>