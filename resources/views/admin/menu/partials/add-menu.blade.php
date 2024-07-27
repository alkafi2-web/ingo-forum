<form id="menuForm" action="" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label class="text-3xl mb-2 required">Select Menu Type</label>
                <div class="form-check mb-2">
                    <input class="form-check-input menu-type" type="radio" name="menu_type" id="menu_type_page" value="page">
                    <label class="form-check-label" for="menu_type_page">Pages</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input menu-type" type="radio" name="menu_type" id="menu_type_post" value="post">
                    <label class="form-check-label" for="menu_type_post">Post Type</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input menu-type" type="radio" name="menu_type" id="menu_type_route" value="route">
                    <label class="form-check-label" for="menu_type_route">Route</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input menu-type" type="radio" name="menu_type" id="menu_type_url" value="url">
                    <label class="form-check-label" for="menu_type_url">Custom URL</label>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3" id="page_select_div" style="display: none;">
        <div class="col-md-12">
            <div class="form-group">
                <label for="page_id" class="text-3xl required">Select Page</label>
                <select class="form-control" id="page_id" name="page_id">
                    <!-- Options populated dynamically -->
                </select>
            </div>
        </div>
    </div>

    <div class="row mb-3" id="post_select_div" style="display: none;">
        <div class="col-md-12">
            <div class="form-group">
                <label for="postCat_id" class="text-3xl required">Select Post Type</label>
                <select class="form-control" id="postCat_id" name="postCat_id">
                    <!-- Options populated dynamically -->
                </select>
            </div>
        </div>
    </div>

    <div class="row mb-3" id="menutitle_input_div" style="display: none;">
        <div class="col-md-12">
            <div class="form-group">
                <label for="menu_title" class="text-3xl required">Menu Title</label>
                <input type="text" class="form-control" id="menu_title" name="menu_title" value="{{ old('menu_title') }}">
            </div>
        </div>
    </div>

    <div class="row mb-3" id="route_input_div" style="display: none;">
        <div class="col-md-12">
            <div class="form-group">
                <label for="route_name" class="text-3xl required">Route Name</label>
                <input type="text" class="form-control" id="route_name" name="route_name" value="{{ old('route_name') }}">
            </div>
        </div>
    </div>

    <div class="row mb-3" id="url_input_div" style="display: none;">
        <div class="col-md-12">
            <div class="form-group">
                <label for="custom_url" class="text-3xl required">Custom URL</label>
                <input type="text" class="form-control" id="custom_url" name="custom_url" value="{{ old('custom_url') }}">
            </div>
        </div>
    </div>

    <button id="menu-submit" type="submit" class="btn btn-primary mt-3"><i class="fas fa-upload"></i> Add</button>
    <button id="menu-update" type="submit" class="btn btn-primary mt-3" style="display: none;"><i class="fas fa-wrench"></i> Update</button>
    <button id="menu-refresh" type="button" class="btn btn-secondary mt-3"><i class="fas fa-sync"></i> Refresh</button>
</form>

@push('custom-js')
    <script>
    $(document).ready(function() {
        function loadPages() {
            $.ajax({
                url: '{{ route("menu.pages") }}',
                method: 'GET',
                success: function(response) {
                    var options = '<option value="">Select Page</option>';
                    response.forEach(function(page) {
                        options += `<option value="${page.id}">${page.title}</option>`;
                    });
                    $('#page_id').html(options);
                },
                error: function() {
                    toastr.error('Error loading pages');
                }
            });
        }

        function loadPost() {
            $.ajax({
                url: '{{ route("menu.post.type") }}',
                method: 'GET',
                success: function(response) {
                    var options = '<option value="">Select Post Type</option>';
                    response.forEach(function(postCat) {
                        options += `<option value="${postCat.id}">${postCat.name}</option>`;
                    });
                    $('#postCat_id').html(options);
                },
                error: function() {
                    toastr.error('Error loading posts');
                }
            });
        }

        $('input[name="menu_type"]').on('change', function() {
            var selectedType = $(this).val();
            $('#page_select_div').hide();
            $('#route_input_div').hide();
            $('#url_input_div').hide();
            $('#post_select_div').hide();

            if (selectedType == 'page') {
                $('#page_select_div').show();
                $('#menutitle_input_div').hide();
                loadPages();
            } else if (selectedType == 'post') {
                $('#post_select_div').show();
                $('#menutitle_input_div').show();
                loadPost();
            } else if (selectedType == 'route') {
                $('#menutitle_input_div').show();
                $('#route_input_div').show();
            } else if (selectedType == 'url') {
                $('#menutitle_input_div').show();
                $('#url_input_div').show();
            }
        });

        $('#menuForm').on('submit', function(event) {
            event.preventDefault();

            var menuType = $('input[name="menu_type"]:checked').val();
            var pageId = $('#page_id').val();
            var postCatId = $('#postCat_id').val();
            var menuTitle = $('#menu_title').val();
            var routeName = $('#route_name').val();
            var customUrl = $('#custom_url').val();

            if (!menuType) {
                toastr.error('Menu Type is required');
                return;
            }
            
            if (menuType == 'page' && !pageId) {
                toastr.error('Please select a page');
                return;
            } else if (menuType == 'post' && !postCatId) {
                toastr.error('Post Type is required');
                return;
            } else if ((menuType == 'post' || menuType == 'route' || menuType == 'url') && !menuTitle) {
                toastr.error('Menu Title is required');
                return;
            } else if (menuType == 'route' && !routeName) {
                toastr.error('Route Name is required');
                return;
            } else if (menuType == 'url' && !customUrl) {
                toastr.error('Custom URL is required');
                return;
            }

            var formData = new FormData(this);
            $.ajax({
                url: '{{ route("menu.store") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        refreshMenu()
                        $('#menuForm')[0].reset();
                        $('#page_select_div').hide();
                        $('#route_input_div').hide();
                        $('#url_input_div').hide();
                        $('#post_select_div').hide();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                }
            });
        });
        function refreshMenu() {
            $.get(window.location.href, function(data) {
                var newMenuContainer = $(data).find('#menu-container').html();
                $('#menu-container').html(newMenuContainer);
            });
        }
    });
    </script>
@endpush
