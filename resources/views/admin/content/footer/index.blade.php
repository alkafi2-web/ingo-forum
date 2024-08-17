@extends('admin.layouts.backend-layout')
@section('breadcame')
    Footer
@endsection
@section('admin-content')
<div class="card footer-management w-100 p-2">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                @include('admin.content.footer.partials.element-tabpane')
            </div>
            <div class="col-md-9">
                @include('admin.content.footer.partials.generated-html')
            </div>
        </div>
    </div>
</div>
@endsection

