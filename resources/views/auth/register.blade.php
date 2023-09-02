@extends('layouts.auth')

@section('page-title')
    {{ __("Plant") }}{{ __("AI") }} | {{ __("Register") }}
@endsection

@section('content')
<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="/" class="h1"><b>{{ __("Plant") }}</b><em>{{ __("AI") }}</em></a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">{{ __("Register a new membership") }}</p>

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="icon fas fa-ban"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="input-group mb-3">
                    <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __("Email") }}" value="{{ old('email') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                    <span class="text-danger" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __("Password") }}" value="{{ old('password') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                    <span class="text-danger" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="{{ __("Confirm Password") }}" value="{{ old('password_confirmation') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password_confirmation')
                    <span class="text-danger" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-8">
                        <button type="submit" class="btn btn-primary btn-block">{{ __("Sign up") }}</button>
                    </div>
                </div>
            </form>

            <p class="mb-0 mt-3">
                <a href="{{ route('login') }}" class="text-center">{{ __("I already have a account") }}</a>
            </p>
        </div>
    </div>
</div>
@endsection
