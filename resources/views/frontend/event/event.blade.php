@extends('frontend.layouts.frontend-page-layout')
@section('page-title', 'Events')
@section('frontend-section')
<section class="event-wrapper pt-5 pb-5">
    <div class="container">
        @forelse($events as $event)
            <div class="card-media">
                <!-- media container -->
                <div class="card-media-object-container">
                    <div class="card-media-object" style="background-image: url({{ asset('public/frontend/images/events/'.($event->media ?? 'placeholder.jpg')) }});"></div>
                    
                    @php
                        $now = \Carbon\Carbon::now();
                    @endphp
                    
                    @if ($event->end_date < $now)
                        <span class="card-media-object-tag subtle bg-danger text-light"><i class="fas fa-info-circle"></i>&nbsp;Expired</span>
                    @elseif ($event->start_date > $now)
                        <span class="card-media-object-tag subtle bg-warning text-dark"><i class="fas fa-info-circle"></i>&nbsp;Upcoming</span>
                    @else
                        <span class="card-media-object-tag subtle bg-success text-light"><i class="fas fa-info-circle"></i>&nbsp;Ongoing</span>
                    @endif

                    <ul class="card-media-object-social-list">
                        @foreach($event->participants->take(2) as $participant)
                            <li>
                                <img src="{{ asset('public/frontend/images/events')."/".($participant->member?$participant->member->info->logo?$participant->member->info->logo:"placeholder.jpg":"placeholder.jpg")  }}" class="">
                            </li>
                        @endforeach
                        @if($event->participants->count() > 2)
                            <li class="card-media-object-social-list-item-additional">
                                <span>+{{ $event->participants->count() - 2 }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
                <!-- body container -->
                <div class="card-media-body">
                    <div class="card-media-body-top">
                        <span class="subtle"><i class="fas fa-calendar-alt"></i> &nbsp;{{ $event->start_date->format('D, M d, h:i A') }} to {{ $event->end_date->format('D, M d, h:i A') }}</span>
                        <div class="card-media-body-top-icons u-float-right">
                            {!! Share::page(route('frontend.event.show', $event->slug), $event->title)->facebook()->twitter()->linkedin()->whatsapp() !!}
                        </div>
                    </div>
                    <span class="card-media-body-heading">{{ $event->title }}</span>
                    <div class="card-media-body-supporting-bottom">
                        <span class="card-media-body-supporting-bottom-text subtle"><i class="fas fa-map-marker-alt"></i>&nbsp; {{ $event->location }}</span>
                        <span class="card-media-body-supporting-bottom-text subtle u-float-right">{{ $event->ref_fees ?? '৳0' }}</span>
                    </div>
                    <div class="card-media-body-supporting-bottom card-media-body-supporting-bottom-reveal">
                        <span class="card-media-body-supporting-bottom-text subtle"><i class="fas fa-feather"></i>&nbsp;{{ $event->creator->name??$event->creator->info->organisation_name }}</span>
                        <a href="{{ route('frontend.event.show', $event->slug) }}" class="card-media-body-supporting-bottom-text card-media-link u-float-right">VIEW DETAILS</a>
                    </div>
                </div>
            </div>
        @empty
            <p>No events available.</p>
        @endforelse
        <!-- Pagination links -->
        <div class="mt-4 event-pagination justify-content-end">
            {{ $events->links() }}
        </div>
    </div>
</section>
@endsection

@push('custom-js')
@endpush
