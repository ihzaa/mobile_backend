<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session()->get('alert'))
    <script>
        Swal.fire({
            'icon': "{{ session()->get('alert-icon') }}",
            'title': "{{ session()->get('alert-title') }}",
            'text': "{{ session()->get('alert-text') }}",
        })
    </script>
@endif
@if ($errors->any())
    <script>
        Swal.fire({
            'icon': "error",
            'title': "{{ $errors->first() }}",
        })
    </script>
@endif
