@extends('admin.layouts.backend-layout')
@section('breadcame')
    FAQs
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">FAQs List</h2>
                </div>
                <div class="card-body">
                    @include('admin.faqs.datatables.faq-list-datatable')
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 " id="add-header">Add FAQ Content</h2>
                </div>
                <div class="card-body">
                    @include('admin.faqs.partials.add-faq')
                </div>
            </div>
        </div>
    </div>
@endsection