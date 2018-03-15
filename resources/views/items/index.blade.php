@extends('layouts.app')
@section('content')
    <div id="items">
        <items :categories="{{ $categories->toJson() }}" :user="{{ Auth::user() }}"></items>
    </div>
@endsection
@section('extra-js')
    <script src="/js/items.js"></script>
@endsection