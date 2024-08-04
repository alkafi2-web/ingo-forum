<div>
    <h4> {{ $post->title}}
        <!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
</div>
{{-- @can('post-management') --}}
    <div>
        @if ($post->approval_status != 3)
            <a href="#" id="" data-post-id="{{ $post->id }}"
                class="{{ $post->approval_status == 0 || $post->approval_status == 2 ? 'approveButton' : '' }} btn btn-success mr-2 {{ $post->approval_status == 1 ? 'disabled' : '' }}">
                <i class="fas fa-check-circle"></i><span>
                    {{ $post->approval_status == 1 || $post->approval_status == 2 ? 'Active' : ($post->approval_status == 0 ? 'Approved' : '') }}
                </span>
            </a>
        @endif
        <a href="#" id="" data-post-id="{{ $post->id }}"
            class=" {{ $post->approval_status == 0 ? 'rejectButton' : ($post->approval_status == 1 ? 'suspendButton' : '') }}
            btn btn-danger mr-2 {{ $post->approval_status == 3 || $post->approval_status == 2 ? 'disabled' : '' }}">
            <i class="fas fa-exclamation-triangle"></i>
            <span>
                {{ $post->approval_status == 0 ? 'Reject' : ($post->approval_status == 3 ? 'Rejected' : ($post->approval_status == 1 ? 'Suspend' : ($post->approval_status == 2 ? 'Suspended' : ''))) }}
            </span>
        </a>

    </div>
{{-- @endcan --}}
