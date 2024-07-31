@extends('frontend.layouts.frontend-page-layout')
@section('page-title', 'Events')
@section('frontend-section')
<section class="event-wrapper ptb-50">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="event-details">
                    <h2 class="event-title">Events</h2>
                    <h3 class="event-date" id="event-date"></h3>
                    <div class="event-message" id="event-message">Sorry, no events to selected date</div>
                </div>
            </div>
            <div class="col-md-8">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('custom-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            dateClick: function(info) {
                var dateStr = moment(info.date).format('MMMM D, YYYY');
                document.getElementById('event-date').innerText = dateStr;

                // Fetch events for the selected date
                fetchEvents(info.dateStr);
            }
        });
        calendar.render();
    });

    function fetchEvents(date) {
        var url = `{{ route('frontend.event.show', ['date' => ':date']) }}`.replace(':date', date);
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.events.length > 0) {
                    var eventHtml = data.events.map(event => {
                        return `<div>
                                    <h4>${event.title}</h4>
                                    <p>${event.details}</p>
                                    ${event.media ? `<img src="/path/to/media/${event.media}" alt="event image">` : ''}
                                    <p>Location: ${event.location}</p>
                                    <p>Type: ${event.type}</p>
                                    <p>Start Date: ${moment(event.start_date).format('MMMM D, YYYY')}</p>
                                    <p>End Date: ${moment(event.end_date).format('MMMM D, YYYY')}</p>
                                    <p>Registration Deadline: ${moment(event.reg_dead_line).format('MMMM D, YYYY')}</p>
                                    <p>Fees: ${event.ref_fees}</p>
                                </div>`;
                    }).join('');
                    document.getElementById('event-message').innerHTML = eventHtml;
                } else {
                    document.getElementById('event-message').innerText = 'Sorry, no events to selected date';
                }
            });
    }
</script>
@endpush
