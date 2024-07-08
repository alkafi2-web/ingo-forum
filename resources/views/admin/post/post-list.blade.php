@extends('admin.layouts.backend-layout')
@section('breadcame')
    Post List
@endsection
@section('admin-content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="pt-5">Post List</h2>
            </div>
            <div class="card-body">
                @include('admin.post.datatables.post-list-datatable')
            </div>
        </div>
    </div>
</div>
@endsection
