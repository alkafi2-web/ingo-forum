@extends('admin.layouts.backend-layout')
@section('breadcame')
    Subscriber List
@endsection
@section('admin-content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="pt-5">Subscriber List</h2>
            </div>
            <div class="card-body">
                @include('admin.subscriber.datatables.subscriber-list-datatable')
            </div>
        </div>
    </div>
</div>
@endsection
