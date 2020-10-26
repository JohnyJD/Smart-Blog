@extends('layouts.app')

@section('content')
<a href="/">
    <div class="main-logo">
        <svg xmlns="http://www.w3.org/2000/svg" width="218" height="227.161" viewBox="0 0 218 227.161"><g transform="translate(-9.8)"><path d="M144.694,198.509v6.637a10.527,10.527,0,0,1-8.928,10.423l-1.636,6.03a7.5,7.5,0,0,1-7.245,5.562H110.667a7.5,7.5,0,0,1-7.245-5.562l-1.589-6.03a10.574,10.574,0,0,1-8.974-10.47v-6.637a6.383,6.383,0,0,1,6.4-6.4h39.029A6.453,6.453,0,0,1,144.694,198.509Zm30.054-89.462a55.68,55.68,0,0,1-15.7,38.842A51.318,51.318,0,0,0,145.3,175.746a9.253,9.253,0,0,1-9.161,7.806H101.412a9.164,9.164,0,0,1-9.114-7.759,51.887,51.887,0,0,0-13.835-27.951,55.956,55.956,0,1,1,96.286-38.8ZM125.11,75.16a6.314,6.314,0,0,0-6.31-6.31,40.425,40.425,0,0,0-40.384,40.384,6.31,6.31,0,1,0,12.62,0A27.8,27.8,0,0,1,118.8,81.47,6.284,6.284,0,0,0,125.11,75.16ZM118.8,34.729a6.313,6.313,0,0,0,6.31-6.31V6.31a6.31,6.31,0,1,0-12.62,0V28.419A6.314,6.314,0,0,0,118.8,34.729ZM44.529,109a6.314,6.314,0,0,0-6.31-6.31H16.11a6.31,6.31,0,0,0,0,12.62H38.219A6.284,6.284,0,0,0,44.529,109Zm176.961-6.31H199.381a6.31,6.31,0,0,0,0,12.62H221.49a6.31,6.31,0,1,0,0-12.62ZM57.382,161.537,41.724,177.2a6.3,6.3,0,0,0,8.881,8.928l15.658-15.658a6.3,6.3,0,1,0-8.881-8.928Zm118.395-103.2a6.3,6.3,0,0,0,4.44-1.823l15.658-15.658a6.313,6.313,0,0,0-8.928-8.928L171.29,47.582a6.291,6.291,0,0,0,0,8.928A6.409,6.409,0,0,0,175.777,58.333ZM57.382,56.463a6.3,6.3,0,0,0,8.881-8.928L50.6,31.877A6.313,6.313,0,0,0,41.677,40.8ZM180.218,161.537a6.313,6.313,0,1,0-8.928,8.928l15.658,15.658a6.3,6.3,0,0,0,8.881-8.928Z" fill="#00ceff"/></g></svg>
        <h1>SMART BLOG</h1>
    </div>
</a>
<div class="auth-wrapper">
    <form method="POST" action="{{ route('login') }}">
        <h2>Login</h2>
        @csrf

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">

                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span class="checkmark"></span>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>

                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </div>
    </form>
</div>
@endsection
