<label for="{{$name}}" class= "{{$labelClass ?? 'col-sm-2 col-form-label p-0'}}">{{$label}}</label>
<div class="{{$fileClass ?? 'col-sm-4 d-inline'}}">
    <input type="file" name="{{$name}}" id="{{$name}}" class="form-control-file d-inline w-50" accept="image/*, .doc, .docx, .pdf" multiple>
</div>