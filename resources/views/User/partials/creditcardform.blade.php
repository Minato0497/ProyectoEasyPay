
<div class="form-group">
    <label for="username">Titular de la tarjeta</label>
    <input type="text" name="name" placeholder="Jason Doe" required class="form-control">
</div>
<div class="form-group">
    <label for="username">Tipo de tarjeta</label>
    <input type="text" name="credit_card_type" placeholder="Master Card/Visa ..." required class="form-control">
</div>
<div class="form-group">
    <label for="cardNumber">Numeros de la tarjeta</label>
    <div class="input-group">
        <input type="text" name="credit_card_numbers" placeholder="Tu numero de tajeta" class="form-control" required>
        <div class="input-group-append">
            <span class="input-group-text text-muted">
                <i class="fa fa-credit-card" aria-hidden="true"></i>
                <i class="fab fa-cc-visa mx-1"></i>
                <i class="fab fa-cc-amex mx-1"></i>
                <i class="fab fa-cc-mastercard mx-1"></i>
            </span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <label><span class="hidden-xs">Expiración</span></label>
            <div class="input-group">
                <input type="text" placeholder="MM/YY" name="credit_card_expiration_date" class="form-control" required>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group mb-4">
            <label data-toggle="tooltip" title="Three-digits code on the back of your card">CVV
                <i class="fa fa-question-circle"></i>
            </label>
            <input type="number" required class="form-control" name="code">
        </div>
    </div>
</div>
@error(['name','credit_card_type','credit_card_numbers','credit_card_expiration_date','code'])
<small <small class="text-danger">
    {{$message}}
</small>
@enderror
