@extends('admin.layouts.backend-layout')
@section('breadcame')
    publication List
@endsection
@section('admin-content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="pt-5 mb-0">Publication List</h2>
                <a href="{{ route('publication.create') }}" class="btn btn-primary"><span><i class="fas fa-plus-square"></i></span>Add Publication</a>
            </div>
            <div class="col-md-12 mt-3 mb-3 p-3 border-bottom">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="category" class="mr-2">Filter by Category</label>
                            <select id="category" class="custom-select form-control">
                                <option value="">All Category</option>
                                @forelse ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="author" class="mr-2">Filter by Author</label>
                            <select id="author" class="custom-select form-control">
                                <option value="">All Author</option>
                                @forelse ($authors as $author)
                                    <option value="{{ $author }}">{{ $author}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="publisher" class="mr-2">Filter by Publisher</label>
                            <select id="publisher" class="custom-select form-control">
                                <option value="">All Publisher</option>
                                @forelse ($publishers as $publisher)
                                    <option value="{{ $publisher }}">{{ $publisher}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>

                    
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status_filter" class="mr-2">Filter by Status</label>
                            <select id="status_filter" class="custom-select form-control">
                                <option value="">All Status</option>
                                <option value="1">Published</option>
                                <option value="0">Unpublish</option>
                                {{-- <option value="2">Suspend</option>
                                <option value="3">Rejected</option> --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="user" class="mr-2">Filter by User</label>
                            <select id="user" class="custom-select form-control">
                                <option value="">All User</option>
                                @forelse ($addedByUsers as $id => $user)
                                    <option value="{{ $id }}">{{ $user }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="member" class="mr-2">Filter by Member</label>
                            <select id="member" class="custom-select form-control">
                                <option value="">All member</option>
                                @forelse ($addedByMembers as $id => $organisation_name)
                                    <option value="{{ $id }}">{{ $organisation_name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button id="reset-filters" class="btn btn-secondary mt-6"><i class="fas fa-sync-alt"></i>Refresh Filter</button>
                    </div>
                </div>
                
            </div>
            <div class="card-body">
                @include('admin.publication.datatables.publication-list-datatable')
            </div>
        </div>
    </div>
</div>
@endsection
