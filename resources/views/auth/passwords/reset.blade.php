@extends('layouts.dashboard.app', [
    'class' => 'register-page'
])

@section('content')
    <div class="content">
        <div class="container">
            <div class="col-lg-4 col-md-6 ml-auto mr-auto">
                <div class="card card-login">
                    <div class="card-body ">
                        <form class="form">

                            <input id="token" type="hidden" name="token" value="{{ $token }}">

                            <div class="card-header ">
                                <h3 class="header text-center">{{ __('Reset Password') }}</h3>
                            </div>
                            <div class="form-group mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="nc-icon nc-single-02"></i></span>
                                    </div>
                                    <input id="email" class="form-control" placeholder="{{ __('Email') }}" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="nc-icon nc-key-25"></i></span>
                                    </div>
                                    <input id="password" class="form-control" name="password" placeholder="{{ __('Password') }}" type="password" value="{{ old('password') }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="nc-icon nc-key-25"></i></span>
                                    </div>
                                    <input id="password-confirm" class="form-control" name="password_confirmation" placeholder="{{ __('Password Confirmation') }}" type="password" value="{{ old('password_confirmation') }}" required>
                                </div>
                            </div>

                            <div class="text-center">
                                <button id="res_pass" type="button" class="btn btn-warning btn-round mb-3">{{ __('Reset Password') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            demo.checkFullPageBackgroundImage();
        });
    </script>
@endpush
