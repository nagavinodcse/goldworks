@extends('layouts.app')
@section('content')
    <div class="container">
        <div id="users">
            <h1 class="title m-t-20 is-4">Users</h1>
            <users :users="{{ $users->toJson() }}"></users>
        </div>
    </div>
@endsection
@section('extra-js')
    <script src="/js/users.js"></script>
@endsection