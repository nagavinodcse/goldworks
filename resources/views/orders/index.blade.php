@extends('layouts.app')
@section('content')
    <div id="orders">
        <items :orders="{{ $orders->toJson() }}" :user="{{ Auth::user() }}"></items>
    </div>
@endsection
@section('extra-js')
    <script src="/js/orders.js"></script>
@endsection