<div id="publication">
    <ul class="sub-profile-tabs nav nav-tabs mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold active" id="all-publication-tab" data-bs-toggle="tab" data-bs-target="#all-publication"
                type="button" role="tab" aria-controls="all-publication" aria-selected="false" tabindex="-1"><i class="fas fa-file-pdf"></i>&nbsp;All Publication</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="add-publication-tab" data-bs-toggle="tab" data-bs-target="#add-publication"
                type="button" role="tab" aria-controls="add-publication" aria-selected="true"><i class="fas fa-file-medical addPubIcon"></i><i class="fas fa-wrench updatePubIcon" style="display: none"></i>&nbsp;<span class="publication-btn-text">Add Publication</span></button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">

        <div class="tab-pane fade show active" id="all-publication" role="tabpanel" aria-labelledby="all-publication-tab" tabindex="0">
            @include('frontend.member.dashboard.partials.publication.partials.publication-list')
        </div>
        <div class="tab-pane fade " id="add-publication" role="tabpanel" aria-labelledby="add-publication-tab"
            tabindex="0">
            @include('frontend.member.dashboard.partials.publication.partials.add-publication')
        </div>
    </div>
</div>
@include('frontend.member.dashboard.partials.publication.partials.publication-js')

