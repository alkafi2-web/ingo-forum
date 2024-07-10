@extends('admin.layouts.backend-layout')
@section('breadcame')
    Post Sub Category
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">Post  Sub Category List</h2>
                </div>
                <div class="card-body">
                    @include('admin.post.sub-category.datatables.post-subcategory-list-datatable')
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 " id="add-header">Add Post Sub Category</h2>
                </div>
                <div class="card-body">
                    @include('admin.post.sub-category.partials.add-post-sub-category')
                </div>
            </div>
        </div>
    </div>
@endsection

