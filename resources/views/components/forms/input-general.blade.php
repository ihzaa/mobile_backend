{{-- <x-forms.input-general name="email" type="email" label="Email" placeholder="Masukkan Email" required="required" class="mt-5 w-50" /> --}}

<div class="form-group">
    <label for="{{ $name }}">{{ $label }} <span
            class="text-danger">{{ $required == 'required' ? '*' : '' }}</span></label>
    <input type="{{ $type }}" {{ $attributes->merge(['class' => 'form-control']) }} id="{{ $name }}"
        placeholder="{{ $placeholder }}" name="{{ $name }}" {{ $required == 'required' ? $required : '' }}>
    <small class="form-text text-muted">{{ $smallText }}</small>
</div>
