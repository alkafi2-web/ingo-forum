@extends('admin.layouts.backend-layout')
@section('breadcame')
    Post Category
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">Post Category List</h2>
                </div>
                <div class="card-body">
                    @include('admin.post.category.datatables.post-category-list-datatable')
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 " id="add-header">Add Post Category</h2>
                </div>
                <div class="card-body">
                    @include('admin.post.category.partials.add-post-category')
                </div>
            </div>
        </div>
    </div>
@endsection

