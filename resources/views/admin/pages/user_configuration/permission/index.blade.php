@extends('layouts.master')

@section('page_title', 'Perizinan')

@section('breadcrumb')
    @php
    $breadcrumbs = ['Pengaturan User', ['Perizinan', route('admin.user_config.permission.index')]];
    @endphp
    @include('layouts.parts.breadcrumb',['breadcrumbs'=>$breadcrumbs])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-secondary-300">
                <div class="card-header d-flex">
                    <h3 class="card-title mr-auto">List Peran</h3>
                    @can('create Pengaturan_User_Perizinan')
                        <a class="btn btn-primary" href="{{ route('admin.user_config.permission.createGet') }}"><i
                                class="fa fa-plus" aria-hidden="true"></i> Tambah</a>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="main-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Terakhir Update</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('layouts.data_tables.basic_data_tables')

@push('scripts')
    <script>
        $(function() {
            $('#main-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! url()->full() !!}',
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: "text-center"
                    }
                ]
            });
        });
    </script>
@endpush
