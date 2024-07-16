<div>
    Organigation Name: <h4> {{ $member->memberInfos[0]['organisation_name'] }}</h4>
</div>
<div>
    @if ($member->status != 3)
        <a href="#" id="" data-member-id="{{ $member->id }}"
            class="{{ $member->status == 0 || $member->status == 2 ? 'approveButton' : '' }} btn btn-success mr-2 {{ $member->status == 1 ? 'disabled' : '' }}">
            <i class="fas fa-check-circle"></i><span>
                {{ $member->status == 1 || $member->status == 2 ? 'Active' : ($member->status == 0 ? 'Approved' : '') }}
            </span>
        </a>
    @endif

    <a href="#" id="" data-member-id="{{ $member->id }}"
        class=" {{ $member->status == 0 ? 'rejectButton' : ($member->status == 1 ? 'suspendButton' : '') }}
            btn btn-danger mr-2 {{ $member->status == 3 || $member->status == 2 ? 'disabled' : '' }}">
        <i class="fas fa-exclamation-triangle"></i>
        <span>
            {{ $member->status == 0 ? 'Reject' : ($member->status == 3 ? 'Rejected' : ($member->status == 1 ? 'Suspend' : ($member->status == 2 ? 'Suspended' : ''))) }}

        </span>
    </a>

    <a href="{{ route('member.request') }}"><button class="btn btn-info"><i class="fas fa-arrow-left"></i>
            Back</button></a>
</div>
