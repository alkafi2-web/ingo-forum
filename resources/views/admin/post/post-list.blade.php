@extends('admin.layouts.backend-layout')
@section('breadcame')
    Post List
@endsection
@section('admin-content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="pt-5 mb-0">Post List</h2>
                <a href="{{ route('post.create') }}" class="btn btn-primary"><span><i class="fas fa-plus-square"></i></span>Add Post</a>
            </div>
            <div class="card-body">
                @include('admin.post.datatables.post-list-datatable')
            </div>
        </div>
    </div>
</div>
@endsection
