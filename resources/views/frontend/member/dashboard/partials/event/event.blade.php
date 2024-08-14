<div>
    <ul class="sub-profile-tabs nav nav-tabs mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold" id="all-event-tab" data-bs-toggle="tab" data-bs-target="#all-event"
                type="button" role="tab" aria-controls="all-event" aria-selected="false" tabindex="-1"><i class="fas fa-calendar-alt"></i>&nbsp;All
                Event</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="add-event-tab" data-bs-toggle="tab" data-bs-target="#add-event"
                type="button" role="tab" aria-controls="add-event" aria-selected="true"><i class="fas fa-calendar-plus addEventIcon"></i><i class="fas fa-wrench updateEventIcon" style="display: none"></i>&nbsp;<span class="add-event-btn-text">Add Event</span></button>
        </li>

    </ul>
    <div class="tab-content mt-4" id="pills-tabContent">
        <div class="tab-pane fade show active" id="all-event" role="tabpanel" aria-labelledby="all-event-tab" tabindex="0">
            <div class="table-responsive table-container ">
                @include('frontend.member.dashboard.partials.event.partials.event-list')
            </div>
        </div>
        <div class="tab-pane fade " id="add-event" role="tabpanel" aria-labelledby="add-event-tab" tabindex="0">
            @include('frontend.member.dashboard.partials.event.partials.add-event')
        </div>

    </div>
</div>
@include('frontend.member.dashboard.partials.event.partials.event-js')
