<div id="blog-news">
    <ul class="sub-profile-tabs nav nav-tabs mb-3" id="pills-tab" role="tablist">

        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold active" id="all-blog-news-tab" data-bs-toggle="tab"
                data-bs-target="#all-blog-news" type="button" role="tab" aria-controls="all-blog-news"
                aria-selected="false" tabindex="-1"><i class="far fa-newspaper"></i>&nbsp;All
                Blog/News</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="add-blog-news-tab" data-bs-toggle="tab" data-bs-target="#add-blog-news"
                type="button" role="tab" aria-controls="add-blog-news" aria-selected="true"><i
                    class="fas fa-plus-circle addBlogIcon"></i><i class="fas fa-wrench updateBlogIcon"
                    style="display: none"></i>&nbsp;<span class="add-blog-btn-text">Add Blog/News</span></button>
        </li>
    </ul>
    <div class="tab-content mt-4" id="pills-tabContent">
        <div class="tab-pane fade show active" id="all-blog-news" role="tabpanel" aria-labelledby="all-blog-news-tab"
            tabindex="0">
            @include('frontend.member.dashboard.partials.post.partials.post-list')
        </div>
        <div class="tab-pane fade " id="add-blog-news" role="tabpanel" aria-labelledby="add-blog-news-tab"
            tabindex="0">
            @include('frontend.member.dashboard.partials.post.partials.add-post')
        </div>
    </div>
</div>
@include('frontend.member.dashboard.partials.post.partials.post-js')
