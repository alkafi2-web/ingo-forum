@extends('admin.layouts.backend-layout')
@section('breadcame')
    Role & Assign
@endsection
@section('admin-content')
 <!--begin::Content-->
 <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-8">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-end mb-2">
                                    <a href=""  class="btn btn-secondary" ><i class="fa fa-plus"></i>
                                    {{ __('Create_Role') }}</a>
                            </div>
                            <!--begin::Table container-->
                            @include('admin.role.datatables.role-datatable')
                            <!--end::Table container-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
</div>
<!--end::Content-->
@endsection