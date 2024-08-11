@extends('admin.layouts.backend-layout')
@section('breadcame')
    File Sub Category
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">File  Sub Category List</h2>
                </div>
                <div class="card-body">
                    @include('admin.file.sub-category.datatables.file-subcategory-list-datatable')
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 " id="add-header">Add File Sub Category</h2>
                </div>
                <div class="card-body">
                    @include('admin.file.sub-category.partials.add-file-sub-category')
                </div>
            </div>
        </div>
    </div>
@endsection

