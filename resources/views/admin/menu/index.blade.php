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

    <style>
        .draggable-menu-container, .draggable-sub-menu-container {
            list-style-type: none;
            padding: 0;
            margin: 0;
            width: 100%;
        }
        .draggable-menu-item, .draggable-sub-menu-item {
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
        .draggable-menu-item .draggable-menu-name, .draggable-sub-menu-item .draggable-menu-name {
            flex: 1;
        }
        .draggable-menu-item .btn, .draggable-sub-menu-item .btn {
            margin-left: 5px;
        }
        .ui-state-highlight {
            height: 50px;
            background: #ccc;
        }
        .draggable-sub-menu-container {
            padding-left: 20px; /* Indent sub-menus */
        }
        .drop-target {
            background-color: #f9f9f9;
            border: 2px dashed #ccc;
        }
        .menu-hover {
            border: 2px solid #007bff;
        }
    </style>

    @push('custom-js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdn.rawgit.com/mjsarfatti/nestedSortable/master/jquery.mjs.nestedSortable.js"></script>
        <script>
            $(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

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
                    update: function (event, ui) {
                        var serializedData = $(this).nestedSortable('toArray', { attribute: 'id', expression: /menu-(\d+)/ });
                        $.post("{{ route('menu.updateOrder') }}", { order: serializedData })
                            .done(function() {
                                toastr.success('Menu order updated successfully.');
                            })
                            .fail(function() {
                                toastr.error('Failed to update menu order.');
                            });
                    },
                    stop: function (event, ui) {
                        var item = ui.item;
                        var parent = item.parent().closest('li');
                        var parentId = parent.length ? parent.attr('id').replace('menu-', '') : 0;
                        var itemId = item.attr('id').replace('menu-', '');

                        $.post("{{ route('menu.createOrRemoveSubmenu') }}", { submenu: [itemId, parentId] })
                            .done(function() {
                                toastr.success('Sub-menu updated successfully.');
                            })
                            .fail(function() {
                                toastr.error('Failed to update sub-menu.');
                            });

                        // Update the parent menu's has_sub_menu field
                        updateHasSubMenuField(itemId, parentId);
                    }
                });

                function updateHasSubMenuField(itemId, parentId) {
                    // If the item has children, update has_sub_menu to 1
                    var hasSubMenu = $("#menu-" + itemId).find("ul").children("li").length > 0 ? 1 : 0;
                    $.post("{{ route('menu.updateHasSubMenu') }}", { itemId: itemId, hasSubMenu: hasSubMenu });

                    // If the parent has no more children, update has_sub_menu to 0
                    if (parentId) {
                        var parentHasSubMenu = $("#menu-" + parentId).find("ul").children("li").length > 0 ? 1 : 0;
                        $.post("{{ route('menu.updateHasSubMenu') }}", { itemId: parentId, hasSubMenu: parentHasSubMenu });
                    }
                }
            });
        </script>
    @endpush
@endsection
