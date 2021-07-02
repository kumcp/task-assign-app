<div class="mb-3 row">
    <label for="{{ $name }}" class="col-sm-2 col-form-label">{{ __("title.$name") }}</label>
    <div class="col-sm-5">
        @foreach ($options as $option)
            <div class="form-check">
                <input class="form-check-input" type="radio" name="{{ $name }}" value="{{ $option }}"
                    id="{{ $name }}-{{ $option }}" {{ ($select ?? '') == $option ? 'checked': '' }}>
                <label class="form-check-label" for="{{ $name }}-{{ $option }}">
                    {{ __("title.$option") }}
                </label>
            </div>
        @endforeach
    </div>
</div>
