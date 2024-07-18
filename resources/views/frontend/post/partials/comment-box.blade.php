<!-- Contenedor Principal -->
<div class="comments-container">
    <h1>Comment <a href="http://creaticode.com">INGO Forum</a></h1>
    <form action="javascript:void(0)" id="comment-form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <div class="form d-flex align-items-center">
            <img src="{{ asset('public/frontend/images/icons/avatar.png') }}" style="height: 38px;" alt="Your avatar" class="form__avatar">
            <input type="text" name="comment_text" id="comment_text" class="form-control bg-white" placeholder="Write your comment here">
            <button class="commentBtn border-0 bg-white" type="submit"><i class="fas fa-paper-plane"></i></button>
        </div>
    </form>
    <ul id="comments-list" class="comments-list"><!-- comments-container.blade.php -->

        @foreach($post->comments as $comment)
            <li>
                <div class="comment-main-level d-flex">
                    <!-- Avatar -->
                    <div class="comment-avatar"><img src="{{ asset('public/frontend/images/icons/avatar.png') }}" style="height: 38px;" alt="Avatar"></div>
                    <!-- Contenedor del Comentario -->
                    <div class="comment-box">
                        <div class="comment-head">
                            <h6 class="comment-name by-author"><a href="#">{{ $comment->member->info->name }}</a></h6>
                            <span>{{ $comment->created_at->diffForHumans() }}</span>&nbsp;
                            <i class="fas fa-reply reply-btn" data-comment-id="{{ $comment->id }}"></i>
                            <i class="fas fa-heart reaction-btn {{ $comment->userHasReacted() ? 'text-danger' : '' }}" data-comment-id="{{ $comment->id }}"></i>
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
                                    <div class="comment-avatar"><img src="{{ asset('public/frontend/images/icons/avatar.png') }}" style="height: 38px;" alt="Avatar"></div>
                                    <!-- Contenedor del Comentario -->
                                    <div class="comment-box">
                                        <div class="comment-head">
                                            <h6 class="comment-name"><a href="#">Replied By</a></h6>
                                            <span>{{ $reply->created_at->diffForHumans() }}</span>&nbsp;
                                            <i class="fas fa-reply reply-btn" data-comment-id="{{ $comment->id }}"></i>
                                            <i class="fas fa-heart reaction-btn" data-comment-id="{{ $comment->id }}"></i>
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
            </li>
        @endforeach        
    </ul>
</div>
@push('custom-js')
  <script>
    var routes = {
        commentStore: '{{ route("comments.store") }}',
        replyStore: '{{ route("replies.store") }}',
        reactionStore: '{{ route("reactions.react") }}'
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
                console.log(response);
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

    // AJAX for submitting a reply
    $('#comments-list').on('submit', '.reply-form', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var commentId = $(this).data('comment-id');
        $.ajax({
            url: routes.replyStore,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                refreshComment();
                toastr.success('Reply added successfully');
                // Reload comments box or refresh page as needed
            },
            error: function(xhr, status, error) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        toastr.error(value);
                    });
                } else {
                    toastr.error('Failed to add reply');
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
    function refreshComment() {
        $.get(window.location.href, function(data) {
            var commentBox = $(data).find('.comment-wrapper').html();
            $('.comment-wrapper').html(commentBox);
        });
    }
  </script>
@endpush