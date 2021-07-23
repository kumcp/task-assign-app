<label for="{{$name}}" class="{{$labelClass ?? 'col-sm-2 col-form-label p-0'}}">{{$label ?? ''}}</label>
<div class="{{$parentClass ?? 'col-sm-4 d-inline'}}">
    <select name="{{$name}}" id="{{$name}}" class="{{$selectClass ?? 'custom-select w-25'}}">
        @foreach ($options as $option)
            <option value="{{$option['value'] ?? $option['id'] ?? $option }}" @if(isset($checked) && $checked == 1) {{'selected'}} @endif>{{$option['display'] ?? $option['name'] ?? $option }}</option>
        @endforeach
    </select>
</div>

