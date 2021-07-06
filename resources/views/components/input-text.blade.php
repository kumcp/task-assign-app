<label for="{{$name}}" class= "{{$labelClass ?? 'col-sm-2 col-form-label p-0'}}">{{$label}}</label>
<div class="{{$textClass ?? 'col-sm-4 d-inline'}}">
    @if (isset($readonly))
        <input type="text" name="{{$name}}" id="{{$name}}" value="{{$value ?? ''}}" class="{{$inputClass ?? 'form-control d-inline w-25'}}" readonly>
    @else
        <input type="text" name="{{$name}}" id="{{$name}}" value="{{$value ?? ''}}" class="{{$inputClass ?? 'form-control d-inline w-25'}}">
    @endif
</div>    

