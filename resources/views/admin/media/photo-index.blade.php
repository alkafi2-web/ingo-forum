@extends('admin.layouts.backend-layout')
@section('breadcame')
    Photo
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">Photo List</h2>
                </div>
                <div class="card-body">
                    <div class="col-md-12 mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="album_filter" class="mr-2">Filter by Album:</label>
                                    <select id="album_filter" class="custom-select form-control" onchange="filterByAlbum(this.value)">
                                        <option value="">All Albums</option>
                                        @foreach ($albums as $album)
                                            <option value="{{ $album->id }}">{{ $album->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status_filter" class="mr-2">Filter by Status:</label>
                                    <select id="status_filter" class="custom-select form-control" onchange="filterByStatus(this.value)">
                                        <option value="">All Statuses</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('admin.media.datatables.photo-list-datatable')
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 " id="add-header">Add Photo</h2>
                </div>
                <div class="card-body">
                    @include('admin.media.partials.add-photo')
                </div>
            </div>
        </div>
    </div>
@endsection
