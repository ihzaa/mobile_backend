<select class="form-control" id="th-status">
    <option value="1" selected>Aktif</option>
    <option value="0">Dihapus</option>
</select>
@push('scripts')
    <script>
        $(document).ready(() => {
            $("#th-status").change(function() {
                let url = "";
                let tableId = "#{{ isset($table_id) ? $table_id : '' }}";
                if ($(this).val() == "0") {
                    url = "{!! url()->full() !!}?deleted=deleted"
                } else {
                    url = "{!! url()->full() !!}"
                }
                if (tableId == '#') {
                    tableId = $(this).closest('table')[0]
                }
                $(tableId).DataTable().ajax.url(url).load().draw()
            })
        })
    </script>
@endpush
