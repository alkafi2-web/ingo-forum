<form id="bannerForm" action="" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="banner_id" name="id">

    <div class="row mb-3">
        <div class="col-md-12 mb-2">
            <div class="form-group">
                <div class="d-flex align-items-center">
                    <label for="title" class="text-3xl text-nowrap">Banner Title</label>&nbsp;&nbsp;
                    <input type="checkbox" id="titleSwitch" class="form-switch" name="titleSwitch" checked>
                </div>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3" id="titleColorRow">
        <div class="col-md-12 mb-2">
            <div class="form-group d-flex align-items-center">
                <label for="title_color" class="text-3xl text-nowrap">Title Color</label>
                <input type="color" class="" id="title_color" name="title_color" value="#000000">
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12 mb-2">
            <div class="form-group">
                <div class="d-flex align-items-center">
                    <label for="banner_description" class="text-3xl text-nowrap">Banner Description</label>&nbsp;&nbsp;
                    <input type="checkbox" id="descriptionSwitch" class="form-switch" name="descriptionSwitch" checked>
                </div>
                <input type="text" class="form-control" id="banner_description" name="banner_description" value="{{ old('banner_description') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3" id="descriptionColorRow">
        <div class="col-md-12 mb-2">
            <div class="form-group d-flex align-items-center">
                <label for="description_color" class="text-3xl">Description Color</label>
                <input type="color" class="" id="description_color" name="description_color" value="#000000">
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12 mb-2">
            <div class="form-group">
                <label for="background_type" class="text-3xl text-nowrap">Background Type</label>
                <select class="form-control" id="background_type" name="background_type">
                    <option value="image">Image</option>
                    <option value="color">Color</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row mb-3" id="backgroundImageRow">
        <div class="col-md-12">
            <div class="form-group">
                <label for="bg_image" class="text-3xl text-nowrap">Background Image</label>
                <input type="file" class="form-control" id="bg_image" name="bg_image" value="" oninput="pp.src=window.URL.createObjectURL(this.files[0])" onchange="previewImage(event)">
                <p class="text-danger">The banner image must be exactly 1920X768 pixels.</p>
                <img id="pp" width="100" class="float-start mt-3" src="">
            </div>
        </div>
    </div>

    <div class="row mb-3" id="overlayColorRow">
        <div class="col-md-12 mb-2">
            <div class="form-group d-flex align-items-center">
                <label for="overlay_color" class="text-3xl">Overlay Color</label>
                <input class="jscolor {hash:true, mode:'RGBA'} mx-2" id="overlay_color" name="overlay_color" value="rgba(0,0,0,0.5)">
                <input type="checkbox" id="overlaySwitch" class="form-switch" name="overlaySwitch" checked>
            </div>
        </div>
    </div>

    <div class="row mb-3" id="backgroundColorRow" style="display: none;">
        <div class="col-md-12 mb-2">
            <div class="form-group d-flex align-items-center">
                <label for="background_color" class="text-3xl">Background Color</label>
                <input type="color" class="" id="background_color" name="background_color" value="#ffffff">
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12 mb-2">
            <div class="form-group d-flex align-items-center">
                <label for="add_button" class="text-3xl">Add Button</label>&nbsp;&nbsp;
                <input type="checkbox" id="add_button" class="form-switch" name="add_button">
            </div>
        </div>
    </div>

    <div class="row mb-3" id="buttonRow" style="display: none;">
        <div class="col-md-12 mb-2">
            <div class="form-group mb-2">
                <label for="button_text" class="text-3xl">Button Text</label>
                <input type="text" class="form-control" id="button_text" name="button_text" value="{{ old('button_text') }}">
            </div>
            <div class="form-group mb-2 d-flex align-items-center">
                <label for="button_bg_color" class="text-3xl">Button Background Color</label>
                <input type="color" class="" id="button_bg_color" name="button_bg_color" value="#ffffff">
            </div>
            <div class="form-group mb-2 d-flex align-items-center">
                <label for="button_color" class="text-3xl">Button Color</label>
                <input type="color" class="" id="button_color" name="button_color" value="#000000">
            </div>
            <div class="form-group mb-2">
                <label for="button_url" class="text-3xl">Button URL</label>
                <input type="url" class="form-control" id="button_url" name="button_url" value="{{ old('button_url') }}">
            </div>
        </div>
    </div>

    <!-- Position input row -->
    <div class="row mb-3">
        <div class="col-md-12 mb-2">
            <div class="form-group">
                <label for="position" class="text-3xl">Position</label>
                <input type="number" class="form-control" id="position" name="position" value="{{ old('position') }}">
            </div>
        </div>
    </div>

    <button id="banner-submit" type="submit" class="btn btn-primary mt-3"><i class="fas fa-upload"></i> Submit</button>
    <button id="page-refresh" type="button" class="btn btn-secondary mt-3 d-none"><i class="fas fa-sync-alt"></i> Refresh</button>
</form>

@push('custom-js')
<script>
    $(document).ready(function() {
        $('#titleSwitch').change(function() {
            if ($(this).is(':checked')) {
                $('#title').prop('readonly', false);
                $('#title_color').prop('readonly', false);
                $('#titleColorRow').show();
            } else {
                $('#title').val(null).prop('readonly', true);
                $('#title_color').val(null).prop('readonly', true);
                $('#titleColorRow').hide();
            }
        });

        $('#descriptionSwitch').change(function() {
            if ($(this).is(':checked')) {
                $('#banner_description').prop('readonly', false);
                $('#description_color').prop('readonly', false);
                $('#descriptionColorRow').show();
            } else {
                $('#banner_description').val(null).prop('readonly', true);
                $('#description_color').val(null).prop('readonly', true);
                $('#descriptionColorRow').hide();
            }
        });

        $('#background_type').change(function() {
            if ($(this).val() === 'image') {
                $('#backgroundImageRow').show();
                $('#overlayColorRow').show();
                $('#backgroundColorRow').hide();
            } else {
                $('#backgroundImageRow').hide();
                $('#overlayColorRow').hide();
                $('#backgroundColorRow').show();
            }
        });

        $('#add_button').change(function() {
            if ($(this).is(':checked')) {
                $('#buttonRow').show();
            } else {
                $('#buttonRow').hide();
            }
        });

        $('#bannerForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this); // Create FormData object from form

            $.ajax({
                type: 'POST',
                url: "{{ route('banner.createOrUpdate') }}",
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting the content type
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr.success(response.success);
                    $('#bannerForm')[0].reset();
                    $('#pp').attr('src', '');
                    $('#banner-data').DataTable().ajax.reload(null, false);
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value); // Displaying each error message
                    });
                }
            });
        });

        $('#page-refresh').on('click', function(e) {
            e.preventDefault();
            $('#add-header').text('Add Banner Content');
            $('#bannerForm')[0].reset();
            $('#pp').attr('src', '');
            $('#banner-submit').removeClass('d-none');
            $('#banner-update').addClass('d-none');
            $('#page-refresh').addClass('d-none');
        });
    });
</script>
@endpush
