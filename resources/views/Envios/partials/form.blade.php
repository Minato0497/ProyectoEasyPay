<div class="form-group">
    {!! Form::label('correo', 'Correo') !!}
    {!! Form::email('correo', null ,['class'=>'form-control','placeholder'=>'Ingrese el correo a enviar']) !!}
    @error('correo')
    <small <small class="text-danger">
        {{$message}}
    </small>
    @enderror
    <br>
    {!! Form::label('monto', 'Monto') !!}
    {!! Form::number('monto', null, ['class'=>'form-control','placeholder'=>'Ingrese el monto a enviar']) !!}
</div>
