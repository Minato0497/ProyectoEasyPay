<div class="from-group" hidden>
    <input type="text" id="id" name="id" value="{{ auth()->user()->id }}">
</div>
<div class="form-group">
    <label for="correo">Correo</label>
    <input type="email" name="correo" id="correo" placeholder="Ingrese el correo a enviar" class="form-control">
    <span class="text-danger error-text correo_error"></span>
</div>
<div class="form-group">
    <label for="amount">Cantidad</label>
    <input type="number" name="amount" step="0.01" id="amount" placeholder="Ingrese el cantidad a enviar"
        class="form-control">
    <span class="text-danger error-text amount_error"></span>
</div>
{{-- <div class="form-group">
    <label for="correl">Correo</label>
    <input type="email" name="correo" id="correo" placeholder="Ingrese el correo a enviar" class="form-control">
    @error('correo')
        <small <small class="text-danger">
            {{ $message }}
        </small>
    @enderror
    <br>
    <label for="amount">Cantidad</label>
    <input type="number" name="amount" id="amount" placeholder="Ingrese el cantidad a enviar" class="form-control">
</div> --}}
