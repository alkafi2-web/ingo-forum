@extends('admin.layouts.backend-layout')
@section('breadcame')
    Menus
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 " id="page-header">Add New Menu</h2>
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
                <div class="card-body"><div id="menu-container" class="menu-container">
                    @foreach ($menus as $menu)
                        @include('admin.menu.partials.menu-item', ['menu' => $menu])
                    @endforeach
                </div>
                <style>
                    .dragagble-menu-item {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        background-color: #e2e3e5;
                        padding: 10px;
                        border-radius: 5px;
                    }
                    .dragagble-menu-item .dragagble-menu-actions {
                        display: flex;
                    }
                    .dragagble-menu-item .dragagble-menu-actions button {
                        margin-left: 5px;
                    }
                    .btn-delete {
                        background-color: red;
                        color: white;
                    }
                    .btn-edit {
                        background-color: green;
                        color: white;
                    }
                </style>
                </div>
            </div>
        </div>
    </div>
    @push('custom-js')
        <script>
            $(document).ready(function () {
                function makeMenuDraggable() {
                    $('#menu-container').sortable({
                        handle: '.dragagble-menu-item',
                        update: function (event, ui) {
                            var sortedIDs = $(this).sortable('toArray', { attribute: 'data-id' });
                            updateMenuOrder(sortedIDs);
                        }
                    }).disableSelection();
                }
    
                function updateMenuOrder(sortedIDs) {
                    $.ajax({
                        url: '{{ route("menu.updateOrder") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            sortedIDs: sortedIDs
                        },
                        success: function (response) {
                            console.log(response);
                            toastr.success('Menu order updated successfully');
                        },
                        error: function () {
                            toastr.error('Failed to update menu order');
                        }
                    });
                }
    
                makeMenuDraggable();
            });
        </script>
    @endpush
@endsection

