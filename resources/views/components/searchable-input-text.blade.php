<label for="{{$name}}" class= "{{$labelClass ?? 'col-sm-2 col-form-label p-0'}}">{{$label}}</label>
<div class="{{$textClass ?? 'col-sm-4 d-inline'}}">
    <input type="text" name="{{$name}}" id="{{$name}}" list="{{$listId}}" value="{{$value ?? ''}}" class="{{$inputClass ?? 'form-control d-inline w-25'}}">
    <datalist id="{{$listId}}">
        @foreach ($list as $item)
            <option value="{{$item->value ?? $item}}">{{$item->display ?? $item}}</option>
        @endforeach
    </datalist>
</div>    

