@extends('layouts.app')
@section('content')
    <div class="container">
        <div id="app">
            <div class="column is-4 is-offset-4">
                <div class="card m-t-20">
                    <div class="card-header">
                        <div class="card-header-title">Reset Password</div>
                    </div>
                    <div class="card-content">
                        @if (session('status'))
                            <div class="notification is-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('password.request') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="field">
                                <label for="email" class="label">E-Mail Address</label>
                                <div class="control">
                                    <input id="email" type="email" class="input" name="email" value="{{ $email or old('email') }}" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="help is-danger">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>
                            <div class="field">
                                <label for="password" class="label">Password</label>
                                <div class="control">
                                    <input id="password" type="password" class="input" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="help is-danger">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="field{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="label">Confirm Password</label>
                                <div class="control">
                                    <input id="password-confirm" type="password" class="input" name="password_confirmation" required>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help is-danger">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <button type="submit" class="button is-primary">Reset Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra-js')
    <script src="/js/common.js"></script>
@endsection