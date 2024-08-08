<div>
    <h2> {{ $publication->title}}</h2>
        <!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
</div>
{{-- @can('publication-management') --}}
    <div>
        @if ($publication->approval_status != 3)
            <a href="#" id="" data-publication-id="{{ $publication->id }}"
                class="{{ $publication->approval_status == 0 || $publication->approval_status == 2 ? 'approveButton' : '' }} btn btn-success mr-2 {{ $publication->approval_status == 1 ? 'disabled' : '' }}">
                <i class="fas fa-check-circle"></i><span>
                    {{ $publication->approval_status == 1 || $publication->approval_status == 2 ? 'Active' : ($publication->approval_status == 0 ? 'Approved' : '') }}
                </span>
            </a>
        @endif
        <a href="#" id="" data-publication-id="{{ $publication->id }}"
            class=" {{ $publication->approval_status == 0 ? 'rejectButton' : ($publication->approval_status == 1 ? 'suspendButton' : '') }}
            btn btn-danger mr-2 {{ $publication->approval_status == 3 || $publication->approval_status == 2 ? 'disabled' : '' }}">
            <i class="fas fa-exclamation-triangle"></i>
            <span>
                {{ $publication->approval_status == 0 ? 'Reject' : ($publication->approval_status == 3 ? 'Rejected' : ($publication->approval_status == 1 ? 'Suspend' : ($publication->approval_status == 2 ? 'Suspended' : ''))) }}
            </span>
        </a>

    </div>
{{-- @endcan --}}
