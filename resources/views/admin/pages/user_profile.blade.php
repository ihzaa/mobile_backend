@extends('layouts.master')

@section('page_title', 'Pengaturan User')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Edit Profile
                </div>
                <form action="{{ route('admin.profile.update') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nama User..."
                                value="{{ auth()->user()->name }}">
                        </div>
                        <div class="form-group">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" readonly placeholder="Username User..."
                                value="{{ auth()->user()->username }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email User..."
                                value="{{ auth()->user()->email }}">
                        </div>
                        <div class="form-group">
                            <label for="old_password">Password Lama</label>
                            <input type="password" class="form-control" id="old_password" name="old_password"
                                placeholder="Kosongkan kolom password jika tidak ingin merubah password" autocomplete="off"
                                value="">
                        </div>
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Kosongkan kolom password jika tidak ingin merubah password" autocomplete="off"
                                value="">
                            <small>Aturan Password:
                                <ul>
                                    <li>Minimal 8 karakter</li>
                                    <li>Minimal terdapat 1 huruf besar</li>
                                    <li>Minimal terdapat 1 huruf kecil</li>
                                    <li>Minimal terdapat 1 angka</li>
                                </ul>
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Kosongkan kolom password jika tidak ingin merubah password" autocomplete="off"
                                value="">
                        </div>
                    </div>
                    <div class="card-footer text-muted text-center">
                        <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
