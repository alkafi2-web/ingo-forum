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
                    attribute: 'data-id',  // Use data-id for serialization
                    expression: /^(\d+)$/,    // Match numeric values
                    update: function (event, ui) {
                        var serializedData = [];

                        $('#menu-container li').each(function (index) {
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

                        $.post("{{ route('menu.updateOrder') }}", { order: serializedData });
                            // .done(function() {
                            //     toastr.success('Menu order updated successfully.');
                            // })
                            // .fail(function() {
                            //     toastr.error('Failed to update menu order.');
                            // });
                    },
                    stop: function (event, ui) {
                        var item = ui.item;
                        var parent = item.parent().closest('li');
                        var parentId = parent.length ? parent.attr('id').replace('menu-', '') : 0;
                        var itemId = item.attr('id').replace('menu-', '');

                        $.post("{{ route('menu.createOrRemoveSubmenu') }}", { submenu: [itemId, parentId] })
                            .done(function() {
                                toastr.success('Menu updated successfully.');
                            })
                            .fail(function() {
                                toastr.error('Failed to update Menu.');
                            });
                    }
                });
            });
        </script>
    @endpush
    <style>
        ul{
            list-style-type: none;
        }
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
            padding-left: 24px; /* Indent sub-menus */
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
