@csrf
<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control" id="name" placeholder="Peter Parker" name="name">

    <label for="addressPrimary">Dirección 1</label>
    <input type="text" class="form-control" id="addressPrimary" placeholder="Calle 123" name="addressPrimary">

    <label for="addressSecundary">Dirección 2</label>
    <input type="text" class="form-control" id="addressSecundary" placeholder="Calle 123" name="addressSecundary">
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="city">Ciudad</label>
        <input type="text" class="form-control" id="city" placeholder="Barcelona" name="city">
    </div>
    <div class="form-group col-md-6">
        <label for="state">Provincia</label>
        <input type="text" class="form-control" id="state" placeholder="Cataluña" name="state">
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="codCountry">País</label>
        <select id="codCountry" class="form-control" name="codCountry">
            @foreach ($countries as $country)
                <option selected>Choose...</option>
                <option value="{{ $country->codCountry }}">{{ $country->country }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-4">
        <label for="postal_code">Código Postal</label>
        <input type="text" class="form-control" id="postal_code" name="postal_code">
    </div>
</div>
@error(['name', 'addressPrimary', 'postal_code', 'city', 'state', 'country'])
    <small <small class="text-danger">
        {{ $message }}
    </small>
@enderror
