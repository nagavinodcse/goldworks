@extends('layouts.app')
@section('content')
    <div id="categories">
        <div class="container">
            <h1 class="title m-t-20 is-4">Categories
                <a href="{{ route('categories.create') }}" class="is-pulled-right button is-primary">
                    <b-icon icon="plus" size="is-small" custom-class="p-r-5"></b-icon> Add Category
                </a>
            </h1>
            <categories :categories="{{ $categories->toJson() }}"></categories>
        </div>
    </div>
@endsection
@section('extra-js')
    <script src="/js/categories.js"></script>
@endsection
