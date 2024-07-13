@extends('admin.layouts.backend-layout')
@section('breadcame')
    Pages
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-12 col-md-7">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 " id="add-header">Add New Page</h2>
                </div>
                <div class="card-body">
                    @include('admin.content.page.partials.page-form')
                </div>
            </div>
        </div>
        <div class="col-12 col-md-5">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">Page List</h2>
                </div>
                <div class="card-body">
                    @include('admin.content.page.datatables.page-list-datatable')
                </div>
            </div>
        </div>
    </div>
@endsection

