<!-- Contenedor Principal -->
<div class="comments-container">
    <h5><i class="fas fa-share"></i>&nbsp;Share your thought</h5>
    <form action="javascript:void(0)" id="comment-form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <div class="form d-flex align-items-center">
            <img src="{{ asset('public/frontend/images/icons/avatar.png') }}" style="height: 38px;" alt="Your avatar" class="form__avatar">
            <input type="text" name="comment_text" id="comment_text" class="form-control bg-white" placeholder="Write your opinion here">
            <button class="commentBtn border-0 bg-white" type="submit"><i class="fas fa-paper-plane"></i></button>
        </div>
    </form>
    <ul id="comments-list" class="comments-list ps-2"><!-- comments-container.blade.php -->

        @foreach($post->comments as $comment)
            <li class="comment-li">
                <div class="comment-main-level d-flex">
                    <!-- Avatar -->
                    <div class="comment-avatar"><img src="{{ asset('public/frontend/images/icons/avatar.png') }}" alt="Avatar"></div>
                    <!-- Contenedor del Comentario -->
                    <div class="comment-box">
                        <div class="comment-head d-flex align-items-center">
                            <div class="w-100 d-flex align-items-center">
                                <h6 class="comment-name mb-0 {{ Auth::guard('member')->check()?$comment->member->id === Auth::guard('member')->user()->id??'' ?'by-author':'':'' }}"><a href="#">{{ $comment->member->info->organisation_name }}</a></h6>
                                <code>{{ $comment->created_at->diffForHumans() }}</code>&nbsp;
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-reply reply-btn" data-comment-id="{{ $comment->id }}"></i>&nbsp;
                                    <i class="fas fa-heart reaction-btn {{ $comment->userHasReacted() ? 'text-danger' : '' }}" data-comment-id="{{ $comment->id }}"></i>&nbsp;
                                    <small style="color: #999">{{ $comment->reactions->count()??'' }}</small>
                                </div>
                            </div>
                            @if (Auth::guard('member')->check() && $comment->member->id === Auth::guard('member')->user()->id)
                                <i class="fas fa-trash-alt comment-delete-btn text-danger" style="cursor: pointer" data-comment-id="{{ $comment->id }}"></i>&nbsp;
                            @endif
                        </div>
                        <div class="comment-content">
                            {{ $comment->comment_text }}
                        </div>
                    </div>
                </div>
                @if ($comment->replies->count())
                    <!-- Replies -->
                    <ul class="comments-list reply-list">
                        @foreach($comment->replies as $reply)
                            <li>
                                <div class="comment-main-level d-flex">
                                    <!-- Avatar -->
                                    <div class="comment-avatar"><img src="{{ asset('public/frontend/images/icons/avatar.png') }}" alt="Avatar"></div>
                                    <!-- Contenedor del Comentario -->
                                    <div class="comment-box">
                                        <div class="comment-head d-flex align-items-center">
                                            <div class="w-100 d-flex align-items-center">
                                                <h6 class="comment-name mb-0 {{ Auth::guard('member')->check()?$reply->member->id === Auth::guard('member')->user()->id??'' ?'by-author':'':'' }}"><a href="#">{{ $reply->member->info->organisation_name }}</a></h6>
                                                <code>{{ $reply->created_at->diffForHumans() }}</code>&nbsp;
                                            </div>
                                            @if (Auth::guard('member')->check() && $reply->member->id === Auth::guard('member')->user()->id)
                                                <i class="fas fa-trash-alt comment-delete-btn text-danger" style="cursor: pointer" data-reply-id="{{ $reply->id }}"></i>&nbsp;
                                            @endif
                                        </div>
                                        <div class="comment-content">
                                            {{ $reply->reply_text }}
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <form action="javascript:void(0)" id="reply-form{{ $comment->id }}" class="reply-form" data-comment-id="{{ $comment->id }}" method="POST" enctype="multipart/form-data" style="display: none">
                    <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                    <div class="form d-flex align-items-center">
                        <input type="text" name="reply_text" id="reply_text" class="form-control bg-white" placeholder="Write your reply here">
                        <button class="commentBtn border-0 bg-white" name="replybtn{{ $comment->id }}" type="submit"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </form>
            </li>
        @endforeach        
    </ul>
</div>
@push('custom-js')
  <script>
    var routes = {
        commentStore: '{{ route("comments.store") }}',
        replyStore: '{{ route("replies.store") }}',
        reactionStore: '{{ route("reactions.react") }}',
        delete: '{{ route("commentOrReply.delete") }}'
    };
    
    // Function to get CSRF token
    function getCsrfToken() {
        return '{{ csrf_token() }}';
    }
    
    // AJAX setup to include CSRF token in headers
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': getCsrfToken()
        }
    });

    // AJAX for submitting a comment
    $('#comment-form').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: routes.commentStore,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // refreshComment();
                    toastr.success('Comment added successful');
                }
                else{
                    // refreshComment();
                    toastr.error(response.msg);
                }
            },
            error: function(xhr, status, error) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        toastr.error(value);
                    });
                } else {
                    toastr.error('Failed to add comment');
                }
            }
        });
    });

    //AJAX for for showing reply-form 
    $('#comments-list').on('click', '.reply-btn', function(e) {
        // $('.reply-form').hide();
        var commentId = $(this).attr('data-comment-id');
        $('#reply-form'+commentId).toggle();
    });

    // AJAX for submitting a reply
    $('#comments-list').on('submit', '.reply-form', function(e) {
        e.preventDefault();
        var commentId = $(this).data('comment-id');
        var formElement = $('#reply-form' + commentId); // Get the form element by ID
        var formData = formElement.serializeArray(); // Serialize form data
        formData.push({ name: 'comment_id', value: commentId });

        $.ajax({
            url: routes.replyStore, // Assuming routes.replyStore is defined and points to the correct route
            method: 'POST',
            data: formData, // Send the serialized form data
            success: function(response) {
                // refreshComment();
                if (response.success) {
                    toastr.success('Reply added successful');
                }
                else{
                    toastr.error(response.msg);
                }
            },
            error: function(xhr, status, error) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        toastr.error(value);
                    });
                } else {
                    toastr.error('Failed to add reoly');
                }
            }
        });
    });

    // AJAX for reacting to a comment
    $('#comments-list').on('click', '.reaction-btn', function(e) {
        e.preventDefault();
        var commentId = $(this).data('comment-id');
        $.ajax({
            url: routes.reactionStore,
            method: 'POST',
            data: { comment_id: commentId },
            success: function(response) {
                refreshComment();
                toastr.success('Reaction added successfully');
                // Update UI to reflect reaction status
            },
            error: function(xhr, status, error) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        toastr.error(value);
                    });
                } else {
                    toastr.error('Failed to add reaction');
                }
            }
        });
    });

    // AJAX for reacting to a comment
    $('#comments-list').on('click', '.comment-delete-btn', function(e) {
        e.preventDefault();
        var commentId = $(this).data('comment-id');
        var replyId = $(this).data('reply-id');
        swal({
            title: 'Are you sure?',
            text: 'Do you want to delete this comment/reply?',
            icon: 'warning',
            buttons: ["Cancel", true],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: routes.delete,
                    method: 'POST',
                    data: { 
                        comment_id: commentId,
                        reply_id: replyId
                     },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.msg);
                        }
                        else{
                            toastr.error(response.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                toastr.error(value);
                            });
                        } else {
                            toastr.error('Failed to delete');
                        }
                    }
                });
            }
        });
    });

    function refreshComment() {
        $.get(window.location.href, function(data) {
            var commentBox = $(data).find('.comment-wrapper').html();
            $('.comment-wrapper').html(commentBox);
        });
    }
  </script>
@endpush