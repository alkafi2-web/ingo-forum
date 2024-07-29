@extends('admin.layouts.backend-layout')
@section('breadcame')
    Admin Activies
@endsection
@section('admin-content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="pt-5">All Activities</h2>
            </div>
            <div class="card-body">
                @include('admin.user.datatables.activity-list-datatable')
            </div>
        </div>
    </div>
</div>
@endsection
