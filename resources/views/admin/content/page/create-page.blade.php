@extends('admin.layouts.backend-layout')
@section('breadcame')
    {{ !empty($page)?'Update Page':'New Page' }}
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="pt-5 " id="page-header">{{ $page->title??'Add New Page' }}</h2>
                    <a href="{{ route('admin.page') }}" class="btn btn-primary"><span><i class="fas fa-list"></i></span>All Page</a>
                </div>
                <div class="card-body">
                    @include('admin.content.page.partials.page-form')
                </div>
            </div>
        </div>
    </div>
@endsection

