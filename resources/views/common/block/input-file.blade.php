<div class="{{ $parentClass ?? 'mb-3 row' }}">
    <label for="{{ $name }}"
        class="{{ $labelClass ?? 'col-sm-2 col-form-label' }}">{{ __("title.$name") }}</label>
    <div class="{{ $inputClass ?? 'col-sm-5' }}">
        <div class="mb-3">
            <input class="form-control form-control-sm" name="{{ $name }}" type="file">
        </div>
    </div>
</div>
