@extends('admin.layouts.backend-layout')
@section('breadcame')
    Event
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-8 event-list-col">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">Event List &nbsp;
                        <span class="expand" id="expand-list"><i class="fas fa-expand-arrows-alt"></i></span>
                        <span class="compress" id="compress-list" style="display: none;"><i class="fas fa-compress-arrows-alt"></i></span>
                    </h2>
                </div>
                <div class="card-body">
                    @include('admin.event.datatables.event-list-datatable')
                </div>
            </div>
        </div>
        <div class="col-md-4 m-auto add-event-col">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5" id="add-header">Add Event &nbsp;
                        <span class="expand" id="expand-add"><i class="fas fa-expand-arrows-alt"></i></span>
                        <span class="compress" id="compress-add" style="display: none;"><i class="fas fa-compress-arrows-alt"></i></span>
                    </h2>
                </div>
                <div class="card-body">
                    @include('admin.event.partials.add-event')
                </div>
            </div>
        </div>
    </div>

@push('custom-js')
    <script>
        $(document).ready(function () {
            // Expand Event List
            $('#expand-list').on('click', function () {
                $('.event-list-col').removeClass('col-md-8').addClass('col-md-12');
                $('.add-event-col').hide();
                $(this).hide();
                $('#compress-list').show();
            });

            // Compress Event List
            $('#compress-list').on('click', function () {
                $('.event-list-col').removeClass('col-md-12').addClass('col-md-8');
                $('.add-event-col').slideDown('slow');
                $(this).hide();
                $('#expand-list').show();
            });

            // Expand Add Event
            $('#expand-add').on('click', function () {
                $('.add-event-col').removeClass('col-md-4').addClass('col-md-10');
                $('.event-list-col').hide();
                $(this).hide();
                $('#compress-add').show();
            });

            // Compress Add Event
            $('#compress-add').on('click', function () {
                $('.add-event-col').removeClass('col-md-10').addClass('col-md-4');
                $('.event-list-col').slideDown('slow');
                $(this).hide();
                $('#expand-add').show();
            });
        });
    </script>
@endpush
@endsection
