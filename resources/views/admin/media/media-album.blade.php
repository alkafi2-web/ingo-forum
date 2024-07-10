@extends('admin.layouts.backend-layout')
@section('breadcame')
    Media Album
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">Album List</h2>
                </div>
                <div class="card-body">
                    @include('admin.media.datatables.album-list-datatable')
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 " id="add-header">Add Album</h2>
                </div>
                <div class="card-body">
                    @include('admin.media.partials.add-media-album')
                </div>
            </div>
        </div>
    </div>
@endsection

