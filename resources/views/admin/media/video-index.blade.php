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

    <!-- Modal -->
    {{-- <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe src="https://www.youtube.com/embed/Q-Fr04F19G8" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div> --}}
    
    <div class="modal fade" id="videoModal" aria-hidden="true" aria-labelledby="videoModalLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/Q-Fr04F19G8" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
