@extends('frontend.layouts.frontend-page-layout')
@section('page-title', 'Event')
@section('frontend-section')
<section class="event-details-wrapper pt-5 pb-5">
    <div class="container">
        <h2 class="">{{ $event->title }}</h2>
        <div class="mb-1 sub-heading d-flex justify-content-between align-items-center">
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="event-details-socials row w-100 m-0">
                    <div class="info col-sm-12 col-md-4">
                        @php
                            if ($event->creator->info) {
                                $route = route('frontend.member.show', $event->creator->info->membership_id);
                            } else {
                                $route = "javascript:void(0)";
                            }
                        @endphp
                        <p><a href="{{ $route }}" class="text-dark text-decoration-none"><i class="fas fa-feather"></i>&nbsp;{{ $event->creator->name??$event->creator->info->organisation_name }}</a></p>
                    </div>
                    <div class="published-time col-sm-12 col-md-4 d-md-flex justify-content-center">
                        <p><i class="fas fa-globe"></i>&nbsp;{{ $event->created_at->format('D, M d, h:i A') }}</p>
                    </div>
                    <div class="col-sm-12 col-md-4 d-md-flex justify-content-end">
                        {!! Share::page(route('frontend.event.show', $event->slug), $event->title)->facebook()->twitter()->linkedin()->whatsapp() !!}
                    </div>
                </div>
                @if($event->media)
                    <img src="{{ asset('public/frontend/images/events/' . $event->media) }}" class="img-fluid mt-1 mb-4" alt="{{ $event->title }}">
                @endif
                <div>{!! $event->details !!}</div>
            </div>
            <div class="col-md-4">
                <div class="card event-details-card mb-4">
                    <div class="card-body">
                        @php
                            $now = \Carbon\Carbon::now();
                        @endphp
                        @if ($event->reg_enable_status == 1)
                            @if ($event->end_date < $now)
                                <button class="btn btn-danger btn-block mb-3" disabled><i class="fas fa-info-circle"></i> Expired</button>
                            @elseif ($event->start_date->diffInDays($now) <= 1)
                                <button class="btn btn-warning btn-block mb-3 join-form-btn"><i class="fas fa-user-friends"></i> Join</button>
                            @else
                                <button class="btn btn-success btn-block mb-3" disabled><i class="fas fa-info-circle"></i> Ongoing</button>
                            @endif
                            @if ($event->reg_dead_line)
                            <h6 class="card-title"><i class="far fa-clock"></i> Deadline : {{ $event->reg_dead_line->format('D, M d')}}</h6>
                            @endif
                        @endif

                        <h6 class="card-title"><i class="fas fa-calendar-alt"></i> Schedule</h6>
                        <p class="card-text"><strong>Start:</strong> {{ $event->start_date->format('D, M d, h:i A') }}</p>
                        <p class="card-text"><strong>End:</strong> {{ $event->end_date->format('D, M d, h:i A') }}</p>
                        
                        <h6 class="card-title"><i class="fas fa-map-marker-alt"></i> Location</h6>
                        <p class="card-text">{{ $event->location }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('frontend.event.partials.join-form')
</section>
@endsection

@push('custom-js')
<script>
    $(document).ready(function() {
        $('.join-member-btn').click(function() {
            @if(!auth()->guard('member')->check())
                toastr.error('Be a member to join as a member.');
            @else
                $('#joinMemberModal').modal('show');
            @endif
        });

        $('.join-form-btn').click(function() {
            $('#joinFormModal').modal('show');
        });

        $("#participant_number_member").on("keyup change", function(e) {
            let count = $(this).val();
            let container = $('#member_participant_names');
            container.empty();
            for (let i = 1; i <= count; i++) {
                container.append(`
                    <div class="form-group mb-2">
                        <label for="participant_${i}" class="required">Participant ${i} Name</label>
                        <input type="text" class="form-control" id="participant_${i}" name="participant_${i}">
                    </div>
                `);
            }
        });

        $("#participant_number_guest").on("keyup change", function(e) {
            let count = $(this).val();
            let container = $('#guest_participant_names');
            container.empty();
            for (let i = 1; i <= count; i++) {
                container.append(`
                    <div class="form-group mb-2">
                        <label for="guest_participant_${i}" class="required">Participant ${i} Name</label>
                        <input type="text" class="form-control" id="guest_participant_${i}" name="guest_participant_${i}">
                    </div>
                `);
            }
        });
    });
</script>
@endpush
