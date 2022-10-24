<form method="POST" {{ $attributes }}>
    @csrf
    {{ $slot }}
</form>

@if (strpos($attributes->get('class'), '_form_with_confirm') !== false)
    @once
        @push('scripts')
            <script>
                $("._form_with_confirm").submit(function() {
                    event.preventDefault()
                    Swal.fire({
                        title: $(this).data("title"),
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonText: 'Ya',
                        cancelButtonText: `Batal`,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            $(this).unbind('submit').submit();
                        }
                    })
                })

                $("._form_with_confirm_message").submit(async function() {
                    event.preventDefault()

                    const {
                        value: message
                    } = await Swal.fire({
                        title: $(this).data('title') ? $(this).data('title') : 'Alasan melakukan aksi?',
                        input: 'text',
                        inputLabel: $(this).data('message') ? $(this).data('message') : '',
                        showCancelButton: true,
                        inputValidator: (value) => {
                            if (!value) {
                                return 'Input tidak boleh kosong'
                            }
                        }
                    })

                    if (message) {
                        $(this).append(`<input name="message" type="hidden" value="${message}">`)
                        $(this).unbind('submit').submit();
                    }
                })
            </script>
        @endpush
    @endonce
@endif
