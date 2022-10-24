@if ($errors->any())
    <script>
        let inputErrorName = @json($errors->getMessages());
        let inputName = Object.keys(inputErrorName)[0];
        $(`[name='${inputName}']`).addClass('is-invalid');
    </script>
@endif
