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
                            <div class="notification is-success">{{ session('status') }}</div>
                        @endif
                        <form method="POST" action="{{ route('password.email') }}">
                            {{ csrf_field() }}
                            <div class="field{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="label">E-Mail Address</label>
                                <div class="control">
                                    <input id="email" type="email" class="input" name="email" value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                        <span class="help is-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <button type="submit" class="button is-primary">
                                        Send Password Reset Link
                                    </button>
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