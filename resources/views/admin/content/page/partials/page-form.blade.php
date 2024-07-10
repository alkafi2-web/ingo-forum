<form id="bannerForm" action="" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="title" class="text-3xl">Page Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="b_des" class="text-3xl">Page Slug</label>
                <input type="text" class="form-control" id="b_des" name="b_des" value="{{ old('b_des') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="image" class="text-3xl">Banner Image</label>
                <input type="file" class="form-control" id="image" name="image" value=""
                    oninput="pp.src=window.URL.createObjectURL(this.files[0])" onchange="previewImage(event)">
                <img id="pp" width="100" class="float-start mt-3" src="">
            </div>
        </div>
    </div>
    <button id="banner-submit" type="submit" class="btn btn-primary mt-3">Submit</button>
    <button id="banner-update" type="submit" class="btn btn-primary mt-3 d-none">Update</button>
</form>

@push('custom-js')
    <script>
        
    </script>
@endpush
