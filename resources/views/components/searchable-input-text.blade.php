<label for="{{$name}}" class= "{{$labelClass ?? 'col-sm-2 col-form-label p-0'}}">{{$label}}</label>
<div class="{{$textClass ?? 'col-sm-4 d-inline'}}">
    <input type="text" name="{{$name}}" id="{{$name}}" list="{{$listId}}" value="{{$value ?? ''}}" class="{{$inputClass ?? 'form-control d-inline w-25'}}">
    <datalist id="{{$listId}}">
        @if (isset($displayField))
            @foreach ($list ?? [] as $item)
                <option data-value="{{$item['id'] ?? $item}}">{{ $item[$displayField] ?? $item }}</option>
            @endforeach
        @else
            @foreach ($list ?? [] as $item)
                <option  data-value="{{$item['id'] ?? $item}}">{{ $item['name'] ?? $item }}</option>
            @endforeach
        @endif
        
    </datalist>
</div>    

