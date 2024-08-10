@extends('admin.layouts.backend-layout')
@section('breadcame')
    Event Attednee List
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">Event Attendee List</h2>
                </div>
                <div class="col-md-12 mt-3 mb-3 p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event" class="mr-2">Filter by Event Name:</label>
                                <select id="event" class="custom-select form-control"
                                   >
                                    <option value="">All Event</option>
                                   @forelse ($events as $event)
                                       <option value="{{$event->id}}">{{$event->title}}</option>
                                   @empty
                                       <option value="">There is no Event</option>
                                   @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button id="reset-filters" class="btn btn-secondary mt-6"><i class="fas fa-sync-alt"></i>Refresh Filter</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('admin.event.datatables.event-attendee-list-datatable')
                </div>
            </div>
        </div>
    </div>
@endsection

