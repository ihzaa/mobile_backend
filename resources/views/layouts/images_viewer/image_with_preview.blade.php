{{-- Exampe Use

        <img id="img-preview" class="img-fluid m-auto"
            src="{{ asset('assets/images/picture.svg') }}" alt="your image" />
        <label>Foto <span class="text-danger">*</span></label>
        <div class="custom-file mb-5">
            <input type="file" class="custom-file-input img-input" data-previewTarget="#img-preview"
                required name="image">
            <label class="custom-file-label">Foto Berita</label>
        </div>

        - must have img element and it have an id attribute
        - input file must have data-previewTarget attribute, and the value is id of the img element to preview inputed image
        - input must have label element that equal placement with it

--}}

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
