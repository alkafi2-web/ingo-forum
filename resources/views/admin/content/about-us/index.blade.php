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
                    {{-- @include('admin.content.banner.datatables.banner-list-datatable') --}}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 " id="add-header">Add About Us Content</h2>
                </div>
                <div class="card-body">
                    {{-- @include('admin.content.banner.partials.add-banner') --}}
                </div>
            </div>
        </div>
    </div>
@endsection

