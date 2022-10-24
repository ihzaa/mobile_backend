@extends('layouts.master')

@section('page_title', 'Perizinan')

@section('breadcrumb')
    @php
    $breadcrumbs = ['Pengaturan User', ['Perizinan', route('admin.user_config.permission.index')], 'Tambah'];
    @endphp
    @include('layouts.parts.breadcrumb',['breadcrumbs'=>$breadcrumbs])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('admin.user_config.permission.createPost') }}" method="POST">
                    <div class="card-header">
                        Tambah Perizinan
                        <div class="card-tools">

                        </div>
                        <!-- /.card-tools -->
                    </div>
                    @csrf
                    <div class="card-body">
                        <div class="form-group mb-2">
                            <label for="name">Nama Peran<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" placeholder="Nama Peran" name="name"
                                value="{{ old('name') }}">
                        </div>
                        <hr>
                        <h3>Perizinan Spesial</h3>
                        <table class="table table-bordered can-hover">
                            <tbody>

                                <tr class="bg-gray-50">
                                    <th colspan="3" class="text-right">
                                        Select/Unselect Section
                                    </th>
                                    <th class="text-center">
                                        <div class="checkbox c-checkbox" style="display: inline-block; margin: 0 5px;">
                                            <label>
                                                <input type="checkbox" class="toggle-section" data-section="specials" />

                                            </label>
                                        </div>
                                    </th>
                                </tr>

                                <tr class="bg-gray-50">
                                    <th>#</th>
                                    <th>Permission</th>
                                    <th>Deskripsi</th>
                                    <th class="text-center">Enable</th>
                                </tr>

                                <?php $index = 0; ?>
                                @foreach (\App\Utils\PermissionHelper::SPECIAL_PERMISSIONS as $perm => $description)

                                    <tr data-section="specials">
                                        <td>{{ ++$index }}</td>
                                        <td>{{ ucwords(str_replace('_', ' ', $perm)) }}</td>
                                        <td>{{ $description }}</td>
                                        <td class="text-center">
                                            <div class="checkbox c-checkbox">
                                                <label>
                                                    <input name="permissions[]" type="checkbox"
                                                        value="{{ $perm }}" />

                                                </label>
                                            </div>
                                        </td>
                                    </tr>

                                @endforeach

                            </tbody>
                        </table>
                        <hr>
                        <h3>Perizinan Modul</h3>
                        <table class="table table-bordered table-hover">
                            <tbody>

                                @foreach (App\Utils\PermissionHelper::PERMISSIONS as $section => $perms)

                                    <tr class="bg-gray-50">
                                        <th colspan="{{ count(App\Utils\PermissionHelper::ACTIONS) + 1 }}"
                                            class="text-right">Select/Unselect Section</th>
                                        <th class="text-center">
                                            <div class="checkbox c-checkbox" style="display: inline-block; margin: 0 5px;">
                                                <label>
                                                    <input type="checkbox" class="toggle-section"
                                                        data-section="{{ $section }}" />

                                                </label>
                                            </div>
                                        </th>
                                        <th></th>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <th colspan="2">{{ strtoupper(str_replace('_', ' ', $section)) }}</th>
                                        @foreach (App\Utils\PermissionHelper::ACTIONS as $act)
                                            <th class="text-center">
                                                <div class="checkbox c-checkbox"
                                                    style="display: inline-block; margin: 0 5px;">
                                                    <label>
                                                        <input type="checkbox" class="toggle-column"
                                                            data-column="{{ $act }}"
                                                            data-section="{{ $section }}" />

                                                    </label>
                                                </div>
                                            </th>
                                        @endforeach
                                        <th></th>
                                    </tr>

                                    <tr class="bg-gray-50">
                                        <th>#</th>
                                        <th>Modul</th>
                                        @foreach (App\Utils\PermissionHelper::ACTIONS as $act)
                                            <th class="text-center">{{ ucwords($act) }}</th>
                                        @endforeach
                                        <th></th>
                                    </tr>

                                    @foreach ($perms as $index => $perm)

                                        <tr data-section="{{ $section }}">
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ ucwords(str_replace('_', ' ', $perm)) }}</td>
                                            @foreach (App\Utils\PermissionHelper::ACTIONS as $act)
                                                <td class="text-center">
                                                    <div class="checkbox c-checkbox">
                                                        <label>
                                                            <input name="permissions[]" type="checkbox"
                                                                value="{{ $act }} {{ $perm }}"
                                                                class="{{ $act }}" />

                                                        </label>
                                                    </div>
                                                </td>
                                            @endforeach
                                            <td class="text-center">
                                                <div class="checkbox c-checkbox"
                                                    style="display: inline-block; margin: 0 5px;">
                                                    <label>
                                                        <input type="checkbox" class="toggle-row" />
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>

                                    @endforeach

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex">
                        <button class="btn btn-primary ml-auto mr-2" type="submit"><i class="fa fa-check"
                                aria-hidden="true"></i>
                            Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('AdminLTE-3.1.0/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.1.0') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
@endpush

@push('scripts')
    <script>
        $(function() {

            $(".full").change(function() {
                var $this = $(this);
                var tr = $this.closest('tr');
                tr.find('input[type="checkbox"].full').prop('checked', true);
                tr.find('input[type="checkbox"].advanced').prop('checked', true);
                tr.find('input[type="checkbox"].basic').prop('checked', true);
            });

            $(".advanced").change(function() {
                var $this = $(this);
                var tr = $this.closest('tr');
                tr.find('input[type="checkbox"].full').prop('checked', false);
                tr.find('input[type="checkbox"].advanced').prop('checked', true);
                tr.find('input[type="checkbox"].basic').prop('checked', true);
            });

            $(".basic").change(function() {
                var $this = $(this);
                var tr = $this.closest('tr');
                var next = tr.find('input[type="checkbox"].advanced');

                if (next.prop('checked')) {
                    tr.find('input[type="checkbox"].full').prop('checked', false);
                    tr.find('input[type="checkbox"].advanced').prop('checked', false);
                    tr.find('input[type="checkbox"].basic').prop('checked', true);
                }
            });

            $(".toggle-section").change(function() {
                var $this = $(this);
                var section = $this.attr('data-section');
                var tr = $('tr[data-section="' + section + '"]');
                if (this.checked) {
                    tr.find('input[type="checkbox"]').prop('checked', true);
                } else {
                    tr.find('input[type="checkbox"]').prop('checked', false);
                }
            });

            $(".toggle-column").change(function() {
                var $this = $(this);
                var section = $this.attr('data-section');
                var column = $this.attr('data-column');
                var tr = $('tr[data-section="' + section + '"]');
                if (this.checked) {
                    tr.find('input[type="checkbox"].' + column).prop('checked', true);
                } else {
                    tr.find('input[type="checkbox"].' + column).prop('checked', false);
                }
            });

            $(".toggle-row").change(function() {
                var $this = $(this);
                var $tr = $this.closest('tr');
                if (this.checked) {
                    $tr.find('input[type="checkbox"]').prop('checked', true);
                } else {
                    $tr.find('input[type="checkbox"]').prop('checked', false);
                }
            });

            $(".toggle-all").change(function() {
                var body = $('body');
                if (this.checked) {
                    body.find('input[type="checkbox"]').prop('checked', true);
                } else {
                    body.find('input[type="checkbox"]').prop('checked', false);
                }
            });
        });
    </script>
@endpush
