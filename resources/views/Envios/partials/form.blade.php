<div class="form-group">
    <label for="correl">Correo</label>
    <input type="email" name="correo" id="correo" placeholder="Ingrese el correo a enviar" class="form-control">
    @error('correo')
        <small <small class="text-danger">
            {{ $message }}
        </small>
    @enderror
    <br>
    <label for="monto">Cantidad</label>
    <input type="number" name="monto" id="monto" placeholder="Ingrese el cantidad a enviar" class="form-control">
</div>
