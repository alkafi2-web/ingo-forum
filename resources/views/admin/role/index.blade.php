@extends('admin.layouts.backend-layout')
@section('breadcame')
    Role & Assign
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">Role List</h2>
                </div>
                <div class="card-body">
                    @include('admin.role.datatables.role-datatable')
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 " id="add-header">Add Role And Permission</h2>
                </div>
                <div class="card-body">
                    @include('admin.role.partials.add-role-permission')
                </div>
            </div>
        </div>
    </div>
@endsection

