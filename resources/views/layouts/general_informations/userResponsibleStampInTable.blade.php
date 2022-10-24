<tr>
    <th>Dibuat Oleh</th>
    <td>{{ optional($data->createdByUser)->name }}</td>
</tr>
<tr>
    <th>Dibuat Pada</th>
    <td>{{ \Carbon\Carbon::parse($data->created_at)->format('H:i / d-m-Y') }}</td>
</tr>
<tr>
    <th>Diubah Oleh</th>
    <td>{{ optional($data->updatedByUser)->name }}</td>
</tr>
<tr>
    <th>Diubah Pada</th>
    <td>{{ \Carbon\Carbon::parse($data->updated_at)->format('H:i / d-m-Y') }}</td>
</tr>
@if ($data->trashed())
    <tr>
        <th>Dihapus Oleh</th>
        <td>{{ optional($data->deletedByUser)->name }}</td>
    </tr>
    <tr>
        <th>Dihapus Pada</th>
        <td>
            {{ $data->deleted_at == null ? '' : \Carbon\Carbon::parse($data->deleted_at)->format('H:i / d-m-Y') }}
        </td>
    </tr>
@endif
@if ($data->restored_at != null)
    <tr>
        <th>Dikembalikan Oleh</th>
        <td>{{ optional($data->restoredByUser)->name }}</td>
    </tr>
    <tr>
        <th>Dikembalikan Pada</th>
        <td>
            {{ $data->restored_at == null ? '' : \Carbon\Carbon::parse($data->restored_at)->format('H:i / d-m-Y') }}
        </td>
    </tr>
@endif
