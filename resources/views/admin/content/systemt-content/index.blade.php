@extends('admin.layouts.backend-layout')
@section('breadcame')
    Systemt Content
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form id="myForm" action="{{ route('system.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="text-3xl required">System Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name')??$global['website_name'] }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fileInput" class="text-3xl">System Logo</label>
                                    <input type="file" class="form-control" id="fileInput" name="logo"
                                           oninput="pp.src=window.URL.createObjectURL(this.files[0])">
                                    <img id="pp" width="100" class="float-start mt-3" src="{{asset('public/frontend/images/'.$global['logo'])}}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="content" class="text-3xl required">System Short Content</label>
                                    <input type="text" class="form-control" id="content" name="short_content" value="{{ old('short_content') ?? $global['short_content']  }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="text-3xl">Email</label>
                                    <input type="text" class="form-control" id="facebook" name="email" value="{{ old('email') ?? $global['email'] }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="text-3xl">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') ?? $global['phone']  }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="facebook" class="text-3xl">Facebook URL</label>
                                    <input type="text" class="form-control" id="facebook" name="facebook" value="{{ old('facebook') ?? $global['facebook'] }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="linkedin" class="text-3xl">LinkedIn URL</label>
                                    <input type="text" class="form-control" id="linkedin" name="linkedin" value="{{ old('linkedin') ?? $global['linkedin']  }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="youtube" class="text-3xl">YouTube URL</label>
                                    <input type="text" class="form-control" id="youtube" name="youtube" value="{{ old('youtube') ?? $global['youtube'] }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="twitter" class="text-3xl">Twitter URL</label>
                                    <input type="text" class="form-control" id="twitter" name="twitter" value="{{ old('twitter') ?? $global['twitter'] }}">
                                </div>
                            </div>
                        </div>
                        <button id="system-submit" type="submit" class="btn btn-primary mt-3"><i class="fas fa-upload"></i>Submit</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

    {{-- @push('custom-js')
        <script>
            $(document).ready(function() {
                $('#system-submit').on('click', function(e) {
                    e.preventDefault();
                    let form = $('#myForm');
                    let url = form.attr('action');
                    let formData = form.serialize();
                    console.log(formData);
                    $.ajax({
                        enctype: 'multipart/form-data',
                        type: 'POST',
                        url: url,
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response)
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON.errors;
                            // Iterate through each error and display it
                            $.each(errors, function(key, value) {
                                console.log(key, value);
                                toastr.error(value); // Displaying each error message
                            });
                        }
                    });
                });
            });
        </script>
    @endpush --}}
@endsection
