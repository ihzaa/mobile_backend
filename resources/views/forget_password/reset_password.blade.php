@extends('layouts.master-auth')

@section('page-title', 'Halaman Reset Password')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-4 py-4">
            <!-- Header -->
            <div class="text-center">
                <p class="mb-2">
                    <i class="fa fa-2x fa-circle-notch text-primary"></i>
                </p>
                <h1 class="h4 mb-1">
                    Reset Password
                </h1>
                <h2 class="h6 font-w400 text-muted mb-3">
                    Isikan password baru anda, kemudian anda dapat masuk menggunakan password baru.
                </h2>
            </div>
            <!-- END Header -->

            <!-- Reminder Form -->
            <!-- jQuery Validation (.js-validation-reminder class is initialized in js/pages/op_auth_reminder.min.js which was auto compiled from _js/pages/op_auth_reminder.js) -->
            <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
            <form class="js-validation-reminder" action="{{ route('reset.password.store', ['token' => $data->token]) }}"
                method="POST">
                @csrf
                <div class="form-group py-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label style="margin-top: 5px">Email</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control form-control-lg form-control-alt" id="email" name="email"
                                placeholder="Username atau Email" value="{{ $data->email }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group py-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label style="margin-top: 5px">Password Baru</label>
                        </div>
                        <div class="col-md-8">
                            <input type="password" class="form-control" placeholder="Password Baru" name="password">
                        </div>
                    </div>
                </div>
                <div class="form-group py-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label style="margin-top: 5px">Konfirmasi Password</label>
                        </div>
                        <div class="col-md-8">
                            <input type="password" class="form-control" placeholder="Konfirmasi Password Baru"
                                name="password_confirmation">
                        </div>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <div class="col-md-6 col-xl-5">
                        <button type="submit" class="btn btn-block btn-primary">
                            <i class="fa fa-fw fa-save mr-1"></i> Reset Password
                        </button>
                    </div>
                </div>
            </form>
            <!-- END Reminder Form -->

            <div class="text-center">
                <a class="font-size-sm font-w500" href="{{ route('auth.login.get') }}">Login?</a>
            </div>
        </div>
    </div>
@endsection
