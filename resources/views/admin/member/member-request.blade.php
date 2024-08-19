@extends('admin.layouts.backend-layout')
@section('breadcame')
    Member Request
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">Member Request List</h2>
                    
                </div>
                <div class="card-body">
                    @include('admin.member.datatables.member-req-list-datatable')
                </div>
            </div>
        </div>
        {{-- <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 " id="add-header">Add Banner Content</h2>
                </div>
                <div class="card-body">
                    @include('admin.content.banner.partials.add-banner')
                </div>
            </div>
        </div> --}}
    </div>
@endsection