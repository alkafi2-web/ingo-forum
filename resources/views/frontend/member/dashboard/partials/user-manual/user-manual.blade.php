@extends('frontend.member.dashboard.layout')

@section('member-dashboard')
    <div id="user-manual">
        <div id="file-preview">
            @if ($fileUrl)
                <iframe src="{{ $fileUrl }}" width="100%" height="600px"></iframe>
            @else
                <p>File not available.</p>
            @endif
        </div>
    </div>
@endsection
