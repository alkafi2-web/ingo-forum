@extends('admin.layouts.backend-layout')

@section('breadcame')
    Menus
@endsection

@section('admin-content')
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5" id="page-header">Add New Menu</h2>
                </div>
                <div class="card-body">
                    @include('admin.menu.partials.add-menu')
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">Menu List</h2>
                </div>
                <div class="card-body">
                    <ul id="menu-container" class="draggable-menu-container">
                        @foreach ($menus as $menu)
                            @include('admin.menu.partials.menu-item', ['menu' => $menu])
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @push('custom-js')
        <script>
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Initialize nestedSortable
                $("#menu-container").nestedSortable({
                    handle: 'div',
                    items: 'li',
                    toleranceElement: '> div',
                    placeholder: 'ui-state-highlight',
                    listType: 'ul',
                    isTree: true,
                    expandOnHover: 700,
                    startCollapsed: false,
                    maxLevels: 2,
                    attribute: 'data-id',
                    expression: /^(\d+)$/,
                    update: function(event, ui) {
                        var serializedData = [];

                        $('#menu-container li').each(function(index) {
                            var item = $(this);
                            var itemId = item.data('id');
                            var parentId = item.parent().closest('li').data('id') || 0;

                            serializedData.push({
                                item_id: itemId,
                                parent_id: parentId,
                                position: index + 1
                            });
                        });

                        console.log('Serialized Data:', serializedData); // Debugging

                        $.post("{{ route('menu.updateOrder') }}", {
                            order: serializedData
                        });
                    },
                    stop: function(event, ui) {
                        var item = ui.item;
                        var parent = item.parent().closest('li');
                        var parentId = parent.length ? parent.attr('id').replace('menu-', '') : 0;
                        var itemId = item.attr('id').replace('menu-', '');

                        $.post("{{ route('menu.createOrRemoveSubmenu') }}", {
                                submenu: [itemId, parentId]
                            })
                            .done(function() {
                                toastr.success('Menu updated successfully.');
                            })
                            .fail(function() {
                                toastr.error('Failed to update Menu.');
                            });
                    }
                });

                // Enable Menu
                $(document).on('click', '#menuEnableBtn', function() {
                    var menuId = $(this).data('id');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You want to enable this menu item?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, enable it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.post("{{ route('menu.toggleVisibility') }}", {
                                    menu_id: menuId,
                                    visibility: 1
                                })
                                .done(function(response) {
                                    toastr.success('Menu item enabled successfully.');
                                    refreshMenu();
                                })
                                .fail(function() {
                                    toastr.error('Failed to enable menu item.');
                                });
                        }
                    });
                });

                // Disable Menu
                $(document).on('click', '#menuDisableBtn', function() {
                    var menuId = $(this).data('id');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You want to disable this menu item?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, disable it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.post("{{ route('menu.toggleVisibility') }}", {
                                    menu_id: menuId,
                                    visibility: 0
                                })
                                .done(function(response) {
                                    toastr.success('Menu item disabled successfully.');
                                    refreshMenu();
                                })
                                .fail(function() {
                                    toastr.error('Failed to disable menu item.');
                                });
                        }
                    });
                });

                // Delete Menu
                $(document).on('click', '#deleteBtn', function() {
                    var menuId = $(this).data('id');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You want to delete this menu item?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.post("{{ route('menu.delete') }}", {
                                    menu_id: menuId
                                })
                                .done(function(response) {
                                    toastr.success('Menu item deleted successfully.');
                                    refreshMenu();
                                })
                                .fail(function() {
                                    toastr.error('Failed to delete menu item.');
                                });
                        }
                    });
                });

                // Edit Menu
                $(document).on('click', '#editBtn', function() {
                    var menuId = $(this).data('id');
                    $.get("{{ route('menu.edit') }}", {
                            menu_id: menuId
                        })
                        .done(function(response) {
                            var menu = response.menu;
                            $('#page-header').text('Edit Menu');
                            $('input[name="menu_type"][value="' + menu.type + '"]').prop('checked', true)
                                .trigger('change');
                            if (menu.type === 'page') {
                                loadPages(menu.page_id);
                            } else if (menu.type === 'route') {
                                $('#route_name').val(menu.route);
                                $('#menu_title').val(menu.name);
                            } else if (menu.type === 'url') {
                                $('#custom_url').val(menu.url);
                                $('#menu_title').val(menu.name);
                            }
                            $('#menu-submit').hide();
                            $('#menu-update').show().data('id', menu.id);
                        })
                        .fail(function() {
                            toastr.error('Failed to load menu details.');
                        });
                });

                function loadPages(selectedPageId) {
                    $.ajax({
                        url: '{{ route('menu.pages') }}',
                        method: 'GET',
                        success: function(response) {
                            var options = '<option value="">Select Page</option>';
                            response.forEach(function(page) {
                                var selected = page.id == selectedPageId ? 'selected' : '';
                                options +=
                                    `<option value="${page.id}" ${selected}>${page.title}</option>`;
                            });
                            $('#page_id').html(options);
                        },
                        error: function() {
                            toastr.error('Error loading pages');
                        }
                    });
                }

                // Update Menu
                $('#menu-update').on('click', function(event) {
                    event.preventDefault();
                    $('#spinner-update').removeClass('d-none'); // Show the spinner
                    $(this).prop('disabled', true);
                    var menuId = $(this).data('id');
                    var formData = new FormData($('#menuForm')[0]);
                    formData.append('menu_id', menuId);

                    $.ajax({
                        url: "{{ route('menu.update') }}",
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('#spinner-update').addClass('d-none'); // hide the spinner
                            $('#menu-update').prop('disabled', false);
                            toastr.success('Menu item updated successfully.');
                            resetMenuForm();
                            refreshMenu();
                        },
                        error: function(xhr) {
                            $('#spinner-update').addClass('d-none'); // hide the spinner
                            $('#menu-update').prop('disabled', false);
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        }
                    });
                });

                // Refresh Menu Form
                $('#menu-refresh').on('click', function() {
                    resetMenuForm();
                });

                function resetMenuForm() {
                    $('#page-header').text('Add New Menu');
                    $('#menuForm')[0].reset();
                    $('#page_select_div').hide();
                    $('#route_input_div').hide();
                    $('#url_input_div').hide();
                    $('#menu-submit').show();
                    $('#menu-update').hide();
                }


                // Refresh Menu Form
                $('#menu-refresh').on('click', function() {
                    resetMenuForm();
                });

                function resetMenuForm() {
                    $('#page-header').text('Add New Menu');
                    $('#menuForm')[0].reset();
                    $('#page_select_div').hide();
                    $('#route_input_div').hide();
                    $('#url_input_div').hide();
                    $('#menu-submit').show();
                    $('#menu-update').hide();
                }

                function refreshMenu() {
                    $.get(window.location.href, function(data) {
                        var newMenuContainer = $(data).find('#menu-container').html();
                        $('#menu-container').html(newMenuContainer);
                    });
                }
            });
        </script>
    @endpush

    <style>
        ul {
            list-style-type: none;
        }

        .draggable-menu-container,
        .draggable-sub-menu-container {
            list-style-type: none;
            padding: 0;
            margin: 0;
            width: 100%;
        }

        .draggable-menu-item,
        .draggable-sub-menu-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            background: #f0f0f0;
            margin-bottom: 5px;
            border: 1px solid #ddd;
            cursor: move;
            width: 100%;
        }

        .draggable-menu-item .draggable-menu-name,
        .draggable-sub-menu-item .draggable-menu-name {
            flex: 1;
        }

        .draggable-menu-item .btn,
        .draggable-sub-menu-item .btn {
            margin-left: 5px;
        }

        .ui-state-highlight {
            height: 50px;
            background: #ccc;
        }

        .draggable-sub-menu-container {
            padding-left: 26px;
            /* Indent sub-menus */
        }

        .drop-target {
            background-color: #f9f9f9;
            border: 2px dashed #ccc;
        }

        .menu-hover {
            border: 2px solid #007bff;
        }
    </style>
@endsection
