@extends('admin.layouts.backend-layout')
@section('breadcame')
    File Category
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">File Category List</h2>
                </div>
                <div class="card-body">
                    @include('admin.file.category.datatables.file-category-list-datatable')
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 " id="add-header">Add File Category</h2>
                </div>
                <div class="card-body">
                    @include('admin.file.category.partials.add-file-category')
                </div>
            </div>
        </div>
    </div>
@endsection

