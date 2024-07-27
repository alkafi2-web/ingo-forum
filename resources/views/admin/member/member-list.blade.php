@extends('admin.layouts.backend-layout')
@section('breadcame')
    Member Request
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">Member Request List</h2>
                </div>
                <div class="col-md-12 mt-3 mb-3 p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="organization" class="mr-2">Filter by Organization Name:</label>
                                <select id="organization" class="custom-select form-control"
                                   >
                                    <option  selected>Organisation Type</option>
                                    <option value="1">Registered with NGO Affairs Bureau (NGOAB) as an
                                        INGO</option>
                                    <option value="2">Possess international governance structures
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status_filter" class="mr-2">Filter by Status:</label>
                                <select id="status_filter" class="custom-select form-control"
                                    >
                                    <option value="">All Statuses</option>
                                    <option value="1">Active</option>
                                    <option value="0">
                                        
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('admin.member.datatables.member-list-datatable')
                </div>
            </div>
        </div>
        {{-- <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 " id="add-header">Add Banner Content</h2>
                </div>
                <div class="card-body">
                    @include('admin.content.banner.partials.add-banner')
                </div>
            </div>
        </div> --}}
    </div>
@endsection
