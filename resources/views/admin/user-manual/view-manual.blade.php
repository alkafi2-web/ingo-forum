@extends('admin.layouts.backend-layout')

@section('breadcame')
    Admin Manual
@endsection

@section('admin-content')
<!-- User Manual Preview Section -->
<div class="row mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div id="user-manual">
                    <div id="file-preview">
                        @if ($fileUrl)
                            <iframe src="{{ $fileUrl }}" width="100%" height="600px"></iframe>
                        @else
                            <p>File not available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
