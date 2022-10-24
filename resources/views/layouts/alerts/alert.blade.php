<script>
    const Toast = {
        success(title = " ", message = " ") {
            toastr["success"](`${message}`, `${title}`)
        },
        info(title = " ", message = " ") {
            toastr["info"](`${message}`, `${title}`)
        },
        warning(title = " ", message = " ") {
            toastr["warning"](`${message}`, `${title}`)
        },
        error(title = " ", message = " ") {
            toastr["error"](`${message}`, `${title}`)
        },
    };

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": 0,
        "extendedTimeOut": 0,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "tapToDismiss": false
    }
</script>
@if ($errors->any())
    <script>
        Toast.error('{{ $errors->first() }}')
    </script>
@endif
@if (session()->get('alert'))
    <script>
        Toast.{{ session()->get('alert-icon') }}('{{ session()->get('alert-title') }}',
            '{{ session()->get('alert-text') }}')
    </script>
@endif
