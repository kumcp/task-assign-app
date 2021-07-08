<label for="{{$name}}" class= "{{$labelClass ?? 'col-sm-2 col-form-label p-0'}}">{{$label}}</label>
<div class="{{$textClass ?? 'col-sm-4 d-inline'}}">
<<<<<<< HEAD
<<<<<<< HEAD
    <input type="{{$type}}" name="{{$name}}" id="{{$name}}" class="form-control d-inline w-25" value="{{$value ?? ''}}">
=======
    <input type="{{$type ?? 'date'}}" name="{{$name}}" id="{{$name}}" class="form-control d-inline w-25" value={{ old($name) }}>
>>>>>>> 1185776 (update input components and add new flash message)
=======
    
    @if (isset($readonly))
    
        <input type="{{$type ?? 'date'}}" name="{{$name}}" id="{{$name}}" class="form-control d-inline w-25" value={{ $value ?? old($name) }} readonly>

    @else
    
    <input type="{{$type ?? 'date'}}" name="{{$name}}" id="{{$name}}" class="form-control d-inline w-25" value={{ old($name) }}>

    @endif

>>>>>>> f4e582e (update input components for readonly and add new components)
</div>
