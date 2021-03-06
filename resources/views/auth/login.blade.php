@extends('layout.client')

@push('head_links')
    {{-- <script src="https://www.google.com/recaptcha/api.js?render=6LdKJrIUAAAAAALighiAy62sGoZjIFEm8Qy5Cdcf"></script> --}}
@endpush

@section('content')
    <div class="center-container">
        <div class="card" style="max-width: 500px; width: 100%;">
            <div class="card-header">Přihlašovací formulář</div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}" aria-label="Přihlašovací formulář" id="loginForm">
                    @csrf
                    <div class="form-group row">
                        <label for="email" class="col-sm-4 col-form-label text-md-right">E-mail:</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">Heslo:</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    Zapamatovat si přihlášení
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Přihlásit se
                            </button>

                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                Zapomněl jsem heslo
                            </a>
                        </div>
                    </div>

                    <recaptcha site-key="{{ config('recaptcha.key') }}"></recaptcha>
                </form>
            </div>
        </div>
    </div>
@endsection
