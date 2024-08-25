@extends('admin.layouts.backend-layout')
@section('breadcame')
    Member Request
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 d-inline-block">Member Request List</h2>
                    <div id="toggle-filters-container" style="cursor: pointer;" class="d-inline-block pt-5">
                        <i id="toggle-filters" class="fas fa-filter text-primary" style="font-size: 1.5rem;"></i>
                        <span class="fs-2 text-primary ml-2">Filter</span>
                    </div>
                </div>
                <div class="col-md-12 px-5">
                    <div class="row mt-3" id="filter-section" style="display:none;">
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="organization" class="mr-2">Filter by Organization Name:</label>
                                <select id="organization" class="custom-select form-control">
                                    <option value="">All Organization</option>
                                    <option value="1">Registered with NGO Affairs Bureau (NGOAB) as an
                                        INGO</option>
                                    <option value="2">Possess international governance structures
                                    </option>
                                </select>
                            </div>
                        </div> --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status_filter" class="mr-2">Filter by Status:</label>
                                <select id="status_filter" class="custom-select form-control">
                                    <option value="">All Status</option>
                                    <option value="1">Approved</option>
                                    <option value="2">Suspend</option>
                                    <option value="0">Pending</option>
                                    <option value="3">Reject</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <button id="reset-filters" class="btn btn-secondary"><i class="fas fa-sync-alt"></i></button>
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

@push('custom-js')
    <script>
        // Toggle filter section with animation when the icon or text is clicked
        $('#toggle-filters-container').on('click', function() {
            $('#filter-section').slideToggle(300); // Slide up/down animation
            $('#toggle-filters').fadeOut(150, function() { // Fade out the icon before switching
                $(this).toggleClass('fa-filter fa-times').fadeIn(150); // Switch icon with fade effect
            });
        });
    </script>
@endpush
