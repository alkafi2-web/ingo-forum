@extends('admin.layouts.backend-layout')
@section('breadcame')
    Publication Category
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">Publication Category List</h2>
                </div>
                <div class="card-body">
                    @include('admin.publication.category.datatables.publication-category-list-datatable')
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 " id="add-header">Add Publication Category</h2>
                </div>
                <div class="card-body">
                    @include('admin.publication.category.partials.add-publication-category')
                </div>
            </div>
        </div>
    </div>
@endsection

