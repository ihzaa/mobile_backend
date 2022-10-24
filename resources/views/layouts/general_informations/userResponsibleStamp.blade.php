<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Aktifitas Bersangkutan
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Aktivitas</th>
                            <th>Nama User</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Dibuat Oleh</td>
                            <td>{{ optional($data->createdByUser)->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->created_at)->format('H:i d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td>Diupdate Oleh</td>
                            <td>{{ optional($data->updatedByUser)->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->updated_at)->format('H:i d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td>Dihapus Oleh</td>
                            <td>{{ optional($data->deletedByUser)->name }}</td>
                            <td>{{ $data->deleted_at == null ? '' : \Carbon\Carbon::parse($data->deleted_at)->format('H:i d-m-Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Direstore Oleh</td>
                            <td>{{ optional($data->restoredByUser)->name }}</td>
                            <td>{{ $data->restored_at == null ? '' : \Carbon\Carbon::parse($data->restored_at)->format('H:i d-m-Y') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
