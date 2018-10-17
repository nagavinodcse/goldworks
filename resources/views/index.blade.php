@extends('layouts.app')
@section('content')
    <div id="items" class="main-bg">
        <div class="container">
            <item-grid :categories="{{ $categories->toJson() }}"></item-grid>
        </div>
    </div>
@endsection
@section('extra-css')
    @if(request()->session()->has('success'))
        <link rel="stylesheet" href="/css/toastr.min.css">
    @endif
@endsection
@section('extra-js')
    <script src="/js/app.js"></script>
    @if(request()->session()->has('success'))
    <script src="/js/toastr.min.js"></script>
    <script>
        toastr.success('{{ request()->session()->get('success') }}')
    </script>
    @endif
@endsection