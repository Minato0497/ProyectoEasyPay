<div class="from-group" hidden>
    <input type="text" id="id" name="id" value="{{ auth()->user()->id }}">
</div>
<div class="form-group">
    <label for="email">Correo a enviar</label>
    <div class="correos">
        <div class="row">
            <div class="col-11">
                <div class="correo">
                    <input type="email" name="email[]" id="email" class="form-control" placeholder="Correo a enviar"
                        aria-describedby="helpId">
                </div>
            </div>
            <div class="col-1">
                <a href="javascript:void(0);" class="add_button" title="Add field"><i class="fas fa-plus"></i></a>
            </div>
        </div>
    </div>
    <span class="text-danger error-text email_error"></span>
</div>
<div class="form-group">
    <label for="amount">Cantidad</label>
    <input type="number" name="amount" id="amount" placeholder="Ingrese el cantidad a enviar" class="form-control">
    <span class="text-danger error-text amount_error"></span>
</div>
