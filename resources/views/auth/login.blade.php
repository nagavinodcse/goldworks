@extends('layouts.app')
@section('content')
    <div class="container">
        <div id="app">
            <div class="column is-4 is-offset-4">
                <div class="card m-t-20">
                    <div class="card-header">
                        <div class="card-header-title">Login</div>
                    </div>
                    <div class="card-content">
                        <form method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            <b-field {{ ($errors->has('email')) ? ' type =is-danger' : "" }} message="{{ ($errors->has('email')) ? $errors->first('email') : "" }}">
                                <b-input placeholder="Email Or Mobile" type="text" value="{{ old('email') }}" id="email" required autofocus="true" name="email"></b-input>
                            </b-field>
                            <b-field>
                                <b-input type="password" placeholder="Password" name="password" required password-reveal></b-input>
                            </b-field>
                            <input type="hidden" name="remember" value="true">
                            <div class="field">
                                <p class="control">
                                    <button type="submit" class="button is-fullwidth is-primary">Login</button>
                                </p>
                            </div>
                        </form>
                    </div>
                    <footer class="card-footer new-footer">
                        <a href="{{ route('password.request') }}">
                            Forgot Your Password?
                        </a>
                        <a href="{{ route('register') }}" class="is-pulled-right">Want to Register?</a>
                    </footer>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra-js')
    <script src="/js/common.js"></script>
@endsection