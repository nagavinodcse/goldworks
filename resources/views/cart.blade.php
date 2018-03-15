@extends('layouts.app')
@section('content')
    <div id="cart">
        <div class="container">
            <cart-operations :loading="loading"></cart-operations>
        </div>
    </div>
@endsection
@section('extra-js')
    <script src="/js/cart.js"></script>
@endsection