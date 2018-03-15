@extends('layouts.app')
@section('content')
    <div class="container">
        <div id="app">
            <div class="column is-4 is-offset-4">
                <div class="card is-primary m-t-20">
                    <div class="card-header">
                        <div class="card-header-title">Register</div>
                    </div>
                    <div class="card-content">
                        <form method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}
                            <div class="field">
                                <div class="control">
                                    <input id="name" placeholder="Name" type="text" class="input{{ $errors->has('name') ? ' is-danger' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help is-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input id="email" placeholder="Email" type="email" class="input{{ $errors->has('email') ? ' is-danger' : '' }}" name="email" value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                        <span class="help is-danger">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input id="mobile_no" placeholder="Mobile No" type="text" class="input{{ $errors->has('mobile_no') ? ' is-danger' : '' }}" name="mobile_no" value="{{ old('mobile_no') }}" required>
                                    @if ($errors->has('mobile_no'))
                                        <span class="help is-danger">
                                        <strong>{{ $errors->first('mobile_no') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input id="password" placeholder="Password" type="password" class="input{{ $errors->has('password') ? ' is-danger' : '' }}" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="help is-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input id="password-confirm" placeholder="Retype the Password" type="password" class="input" name="password_confirmation" required>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <button type="submit" class="button is-fullwidth is-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <footer class="card-footer new-footer">
                        <a href="{{ route('login') }}">Want to Login?</a>
                    </footer>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra-js')
    <script src="/js/common.js"></script>
@endsection