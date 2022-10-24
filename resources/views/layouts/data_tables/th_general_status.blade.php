<select id="status" class="form-control th-select-option">
    <option value="" selected>Semua ({{$model::withTrashed()->count()}})</option>
    <option value="aktif">Aktif ({{$model::count()}})</option>
    <option value="delete">Dihapus ({{$model::onlyTrashed()->count()}})</option>
</select>
