@extends('admin.layouts.backend-layout')
@section('breadcame')
    Event
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">Event List</h2>
                </div>
                <div class="card-body">
                    @include('admin.event.datatables.event-list-datatable')
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 " id="add-header">Add Event</h2>
                </div>
                <div class="card-body">
                    @include('admin.event.partials.add-event')
                </div>
            </div>
        </div>
    </div>
@endsection

