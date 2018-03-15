@extends('layouts.app')
@section('content')
    <div id="checkout">
        <div class="container">
            <checkout :loading="loading"></checkout>
        </div>
    </div>
@endsection
@section('extra-js')
    <script src="/js/checkout.js"></script>
@endsection