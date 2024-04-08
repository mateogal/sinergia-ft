@extends('layouts.dashboard.app', [
    'class' => 'login-page',
    'backgroundImagePath' => 'images/bg2.jpg'
])

@section('content')
    <div class="content">
        <div class="container">
            <div class="col-lg-4 col-md-6 ml-auto mr-auto">
                <div class="card card-login">
                    <div class="card-body ">
                        <div class="card-header ">
                            <h3 class="header text-center">{{ __('Reset Password') }}</h3>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form class="form" method="">
                            @csrf

                            <div class="form-group mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="nc-icon nc-single-02"></i></span>
                                    </div>
                                    <input id="email" class="form-control" placeholder="{{ __('Email') }}" type="email" name="email" value="{{ old('email') }}" required autofocus>
                                </div>
                            </div>
                            <div class="text-center">
                                <button id="res_pass_email" type="button" class="btn btn-warning btn-round mb-3">{{ __('Send Password Reset Link') }}</button>
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
