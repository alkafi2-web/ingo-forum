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
            /* display: none; */
        }

        .modal-header {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: start;
            align-items: flex-start;
            -ms-flex-pack: justify;
            justify-content: space-between;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #e3e9ef;
            border-top-left-radius: calc(.4375rem - 1px);
            border-top-right-radius: calc(.4375rem - 1px);
        }

        .modal-content {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            width: 100%;
            pointer-events: auto;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #e3e9ef;
            border-radius: .4375rem;
            box-shadow: 0 0.3rem 1.525rem -0.375rem rgba(0, 0, 0, 0.1);
            outline: 0;
        }

        .modal-header {
            -ms-flex-align: center;
            align-items: center;
        }

        button:not(:disabled),
        [type="button"]:not(:disabled),
        [type="reset"]:not(:disabled),
        [type="submit"]:not(:disabled) {
            cursor: pointer;
        }

        button.close {
            padding: 0;
            background-color: transparent;
            border: 0;
        }

        .modal-body {
            position: relative;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1.25rem;
        }
    </style>
@endsection
