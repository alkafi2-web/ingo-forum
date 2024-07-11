@extends('admin.layouts.backend-layout')
@section('breadcame')
    Video
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">Video List</h2>
                </div>
                <div class="card-body">
                    {{-- <div class="col-md-12 mt-3 mb-3">
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
                    </div> --}}
                    @include('admin.media.datatables.video-list-datatable')
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 " id="add-header">Add Video</h2>
                </div>
                <div class="card-body">
                    @include('admin.media.partials.add-video')
                </div>
            </div>
        </div>
    </div>
    <style>
        .ekko-lightbox.modal .modal-header {
            flex-direction: row-reverse !important;
        }

        .modal-header .close {
            padding: 1rem 1.25rem;
            margin: -1rem -1.25rem -1rem auto;
        }
    </style>
@endsection
