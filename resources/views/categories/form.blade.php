@extends('layouts.app')
@section('content')
    <div class="container">
        <div id="app">
            <div class="column is-4 is-offset-4">
                <div class="card">
                    <header class="card-header">
                        <div class="card-header-title">{{ !empty($category->id) ? "Update" : "Add" }} Category</div>
                    </header>
                    <div class="card-content">
                        <form action="{{ !empty($category->id) ? route('categories.update',['id'=>$category->id],false) : route("categories.store") }}" method="post">
                            {{ !empty($category->id) ? method_field('PUT') : "" }} {{ csrf_field() }}
                            <b-field label="Category Name">
                                <b-input name="category_name" value="{{ !empty($category->category_name) ? $category->category_name : "" }}"></b-input>
                            </b-field>
                            <div class="field">
                                <div class="control">
                                    <button type="submit" class="button is-primary">{{ !empty($category->id) ? "Update" : "Add" }} Category</button>
                                    <a href="{{ route('categories.index') }}" class="button is-danger">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra-js')
    <script src="/js/common.js"></script>
@endsection