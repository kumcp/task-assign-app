<div class="{{ $parentClass ?? 'mb-3 row' }}">
    <label for="{{ $name }}"
        class="{{ $labelClass ?? 'col-sm-2 col-form-label' }}">{{ __('title.' . ($name ?? ($label ?? ''))) }}</label>
    <div class="{{ $inputClass ?? 'col-sm-3' }}">
        <input type="number" class="form-control" id="{{ $name }}" name="{{ $name }}" value="{{ $value ?? '' }}" placeholder="{{ $placeholder ?? '' }}">
    </div>
</div>
