@extends('admin.layouts.backend-layout')
@section('breadcame')
    File List
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="pt-5 mb-0">File List</h2>
                    <a href="{{ route('file.create') }}" class="btn btn-primary"><span><i
                                class="fas fa-plus-square"></i></span>Add File</a>
                </div>
                
                <div class="card-body">
                    @include('admin.file.datatables.file-list-datatable')
                </div>
            </div>
        </div>
    </div>
@endsection
