<div>
    <h2> {{ $event->title}}</h2>
        <!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
</div>
{{-- @can('event-management') --}}
    <div>
        @if ($event->approval_status != 3)
            <a href="#" id="" data-event-id="{{ $event->id }}"
                class="{{ $event->approval_status == 0 || $event->approval_status == 2 ? 'approveButton' : '' }} btn btn-success mr-2 {{ $event->approval_status == 1 ? 'disabled' : '' }}">
                <i class="fas fa-check-circle"></i><span>
                    {{ $event->approval_status == 1 || $event->approval_status == 2 ? 'Active' : ($event->approval_status == 0 ? 'Approved' : '') }}
                </span>
            </a>
        @endif
        <a href="#" id="" data-event-id="{{ $event->id }}"
            class=" {{ $event->approval_status == 0 ? 'rejectButton' : ($event->approval_status == 1 ? 'suspendButton' : '') }}
            btn btn-danger mr-2 {{ $event->approval_status == 3 || $event->approval_status == 2 ? 'disabled' : '' }}">
            <i class="fas fa-exclamation-triangle"></i>
            <span>
                {{ $event->approval_status == 0 ? 'Reject' : ($event->approval_status == 3 ? 'Rejected' : ($event->approval_status == 1 ? 'Suspend' : ($event->approval_status == 2 ? 'Suspended' : ''))) }}
            </span>
        </a>

    </div>
{{-- @endcan --}}
