@csrf
<div class="form-group">
    <label for="inputName">Nombre</label>
    <input type="text" class="form-control" id="inputName" placeholder="Peter Parker" name="name">

    <label for="inputAddress">Direccion 1</label>
    <input type="text" class="form-control" id="inputAddress1" placeholder="Calle 123" name="addressPrimary">

    <label for="inputAddress">Direccion 2</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Calle 123" name="addressSecundary">
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="inputAddress2">Ciudad</label>
        <input type="text" class="form-control" id="inputState" placeholder="Barcelona" name="city">
    </div>
    <div class="form-group col-md-6">
        <label for="inputCity">Provincia</label>
        <input type="text" class="form-control" id="inputPostalCode" placeholder="Cataluña" name="state">
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="inputState">Pais</label>
        <select id="inputState" class="form-control" name="country_id">
            @foreach ($countries as $country )
            <option selected>Choose...</option>
            <option value="{{$country->id}}">{{$country->country}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-4">
        <label for="inputZip">Codigo Postal</label>
        <input type="text" class="form-control" id="inputPostalCode" name="postal_code">
    </div>
</div>
@error(['name','addressPrimary','postal_code','city','state','country'])
<small <small class="text-danger">
    {{$message}}
</small>
@enderror
