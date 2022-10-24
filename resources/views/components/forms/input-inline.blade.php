<div class="form-group row">
    <label for="{{ $name }}" class="col-sm-2 col-form-label">{{ $label }} <span
            class="text-danger">{{ $required == 'required' ? '*' : '' }}</span></label>
    <div class="col-sm-10">
        <input type="{{ $type }}" {{ $attributes->merge(['class' => 'form-control']) }}
            id="{{ $name }}" placeholder="{{ $placeholder }}" name="{{ $name }}"
            {{ $required == 'required' ? $required : '' }}>
    </div>
</div>
