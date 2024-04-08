@extends('layouts.dashboard.app', [
    'class' => 'login-page',
    'backgroundImagePath' => 'images/bg2.jpg'
])

@section('content')
    <div class="content">
        <div class="container" style="padding-bottom: 150px">
            <div class="col-lg-4 col-md-6 ml-auto mr-auto">
                <form class="form" method="">
                    @csrf
                    <div class="card card-login">
                        <div class="card-header ">
                            <div class="card-header ">
                                <h3 class="header text-center">{{ __('Login') }}</h3>
                            </div>
                        </div>
                        <div class="card-body ">

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                <input id="email" class="form-control" placeholder="{{ __('Email') }}" type="email" name="email" value="" required autofocus>
                            </div>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                <input id="password" class="form-control" name="password" placeholder="{{ __('Contraseña') }}" type="password" required>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="text-center">
                                <button id="login" type="button" class="btn btn-warning btn-round mb-3">{{ __('Iniciar sesion') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
                <a href="{{ route('password.request') }}" class="btn btn-link">
                    {{ __('Recuperar Contraseña') }}
                </a>
                <a href="#" class="btn btn-link float-right">
                    {{ __('Registrarse') }}
                </a>
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
