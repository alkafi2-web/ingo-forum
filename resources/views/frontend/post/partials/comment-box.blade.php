<!-- Contenedor Principal -->
<div class="comments-container">
    <h1>Comment <a href="http://creaticode.com">INGO Forum</a></h1>
    <form action="{{ route('comments.store', ['postId' => $post->id]) }}" id="comment-form" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form d-flex align-items-center">
            <img src="{{ asset('public/frontend/images/icons/avatar.png') }}" style="height: 38px;" alt="Your avatar" class="form__avatar">
            <input type="text" name="comment_text" id="comment_text" class="form-control bg-white" placeholder="Write your comment here">
            <button class="commentBtn border-0 bg-white"><i class="fas fa-paper-plane"></i></button>
        </div>
    </form>
    <ul id="comments-list" class="comments-list">
        @foreach ($post->comments as $comment)
        <li>
            <div class="comment-main-level d-flex">
                <!-- Avatar -->
                <div class="comment-avatar"><img src="http://i9.photobucket.com/albums/a88/creaticode/avatar_1_zps8e1c80cd.jpg" alt=""></div>
                <!-- Contenedor del Comentario -->
                <div class="comment-box">
                    <div class="comment-head">
                        <h6 class="comment-name by-author"><a href="http://creaticode.com/blog">{{ $comment->member->email }}</a></h6>
                        <span>{{ $comment->created_at->diffForHumans() }}</span>&nbsp;
                        <i class="fas fa-reply replyBtn" data-comment-id="{{ $comment->id }}"></i>
                        <i class="fas fa-heart reactBtn" data-comment-id="{{ $comment->id }}"></i>
                    </div>
                    <div class="comment-content">
                        {{ $comment->comment_text }}
                    </div>
                </div>
            </div>
            <!-- Respuestas de los comentarios -->
            <ul class="comments-list reply-list">
                @foreach ($comment->replies as $reply)
                <li>
                    <!-- Avatar -->
                    <div class="comment-avatar"><img src="http://i9.photobucket.com/albums/a88/creaticode/avatar_2_zps7de12f8b.jpg" alt=""></div>
                    <!-- Contenedor del Comentario -->
                    <div class="comment-box">
                        <div class="comment-head">
                            <h6 class="comment-name"><a href="http://creaticode.com/blog">{{ $reply->member->email }}</a></h6>
                            <span>{{ $reply->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="comment-content">
                            {{ $reply->reply_text }}
                        </div>
                    </div>
                </li>
                @endforeach
                <li class="reply-form">
                    <!-- Avatar -->
                    <div class="comment-avatar"><img src="http://i9.photobucket.com/albums/a88/creaticode/avatar_2_zps7de12f8b.jpg" alt=""></div>
                    <!-- Contenedor del Comentario -->
                    <div class="comment-box">
                        <form action="{{ route('replies.store', ['commentId' => $comment->id]) }}" id="reply-form-{{ $comment->id }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="reply_text" id="reply_text_{{ $comment->id }}" class="form-control bg-white" placeholder="Write your reply here">
                                <button class="commentBtn border-0 bg-white"><i class="fas fa-paper-plane"></i></button>
                            </div>
                        </form>
                    </div>
                </li>
            </ul>
        </li>
        @endforeach
    </ul>
</div>
