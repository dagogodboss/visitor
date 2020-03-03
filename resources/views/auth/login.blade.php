@extends('layouts.app')

@section('content')
    <div class="login-page">

        <div class="login-logo" >
            @if(setting('site_logo'))
                <a href="{{ route('admin') }}">
                    <img src="{{ asset('images/'.setting('site_logo')) }}" style="" alt="" />
                </a>
            @else
                <a href="{{ route('admin') }}">
                    {{ setting('site_name') }}
                </a>
            @endif
        </div>

        <div class="form">
            <form class="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                     </span>
                @endif
                <input id="password" type="password" placeholder="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                      </span>
                @endif
                <button type="submit">login</button>
                <p class="message">
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </p>
            </form>
        </div>
    </div>
@endsection
