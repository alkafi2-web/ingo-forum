@extends('admin.layouts.backend-layout')
@section('breadcame')
    About Us Content
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">About Us Content List</h2>
                </div>
                <div class="card-body">
                    @include('admin.content.about-us.datatables.about-us-content-datatable')
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 " id="add-header">Add About Us Content</h2>
                </div>
                <div class="card-body">
                    @include('admin.content.about-us.partials.add-about-us-content')
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">About Us Feature List</h2>
                </div>
                <div class="card-body">
                    @include('admin.content.about-us.datatables.about-us-feature-datatable')
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 " id="feature-header">Add About Us Feature</h2>
                </div>
                <div class="card-body">
                    @include('admin.content.about-us.partials.add-about-us-feature')
                </div>
            </div>
        </div>
    </div>
@endsection

