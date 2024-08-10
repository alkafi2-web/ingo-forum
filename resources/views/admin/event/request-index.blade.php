@extends('admin.layouts.backend-layout')
@section('breadcame')
    Event Request
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">Event Request List</h2>
                </div>
                <div class="card-body">
                    @include('admin.event.datatables.event-request-list-datatable')
                </div>
            </div>
        </div>
    </div>
@endsection

