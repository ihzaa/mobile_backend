{{-- <x-forms.input-image-with-preview img-preview-id="satu" label="Scan KTP" is-required="TRUE" input-name="image" :img-src="$data->img_path"></x-forms.input-image-with-preview> --}}
{{-- <x-forms.input-image-with-preview img-preview-id="dua" label="Scan KTP" is-required="TRUE" input-name="image"  /> --}}

<div {{ $attributes->merge(['class' => 'col-md-12']) }}>
    <div class="row">
        <div class="col-md-4 d-flex">
            <img id="{{ $imgPreviewId }}" class="img-fluid m-auto"
                src="{{ $imgSrc != null ? $imgSrc : asset('assets/images/picture.svg') }}"
                alt="{{ $imgPreviewId }} preview" />
        </div>
        <div class="col-md-8 d-flex flex-column justify-content-center">
            <label>{{ $label }} <span
                    class="text-danger">{{ $isRequired == 'true' || $isRequired == 'TRUE' ? '*' : '' }}</span></label>
            <div class="custom-file mb-5">
                <input type="file" class="custom-file-input img-input" data-previewTarget="#{{ $imgPreviewId }}"
                    {{ $isRequired == 'true' || $isRequired == 'TRUE' ? 'required' : '' }} name="{{ $inputName }}">
                <label class="custom-file-label">{{ $label }}</label>
            </div>
            <small>
                <ul>
                    @foreach ($notes as $note)
                        <li>{{ $note }}</li>
                    @endforeach
                </ul>
            </small>
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script>
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $(input.dataset.previewtarget).attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }

            $(".img-input").change(function() {
                readURL(this);
                $(this).parent().find('label').html(this.value.split(/(\\|\/)/g).pop())
            });
        </script>
    @endpush
@endonce
