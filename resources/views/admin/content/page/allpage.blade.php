@extends('admin.layouts.backend-layout')
@section('breadcame')
    All Page
@endsection
@section('admin-content')
    <div class="w-100">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="pt-5">All Page</h2>
                <a href="{{ route('admin.page.create') }}" class="btn btn-primary"><span><i class="fas fa-plus"></i></span>Create New Page</a>
            </div>
            <div class="card-body">
                @include('admin.content.page.datatables.page-list-datatable')
            </div>
        </div>
    </div>
@endsection

