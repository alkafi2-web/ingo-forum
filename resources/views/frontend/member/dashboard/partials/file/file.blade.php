<div id="file_ts">
    <ul class="sub-profile-tabs nav nav-tabs mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold active" id="all-public-file-tab" data-bs-toggle="tab" data-bs-target="#all-public-file"
                type="button" role="tab" aria-controls="all-public-file" aria-selected="false" tabindex="-1"><i class="fas fa-file-medical-alt"></i>&nbsp;Public File</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold " id="all-shared-file-tab" data-bs-toggle="tab" data-bs-target="#all-shared-file"
                type="button" role="tab" aria-controls="all-shared-file" aria-selected="false" tabindex="-1"><i class="far fa-file-alt"></i></i>&nbsp;Shared File</button>
        </li>
        

        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="all-file-tab" data-bs-toggle="tab" data-bs-target="#all-file"
                type="button" role="tab" aria-controls="all-file" aria-selected="false" tabindex="-1"><i
                    class="fas fa-file"></i>&nbsp;My File</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="add-file-tab" data-bs-toggle="tab" data-bs-target="#add-file"
                type="button" role="tab" aria-controls="add-file" aria-selected="true"><i
                    class="fas fa-file-medical addPubIcon"></i><i class="fas fa-wrench updatePubIcon"
                    style="display: none"></i>&nbsp;<span class="file-btn-text">Add File</span></button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">

        <div class="tab-pane fade show active" id="all-public-file" role="tabpanel" aria-labelledby="all-public-file-tab"
            tabindex="0">
            @include('frontend.member.dashboard.partials.file.partials.public-file-list')
        </div>

        <div class="tab-pane fade show" id="all-shared-file" role="tabpanel" aria-labelledby="all-shared-file-tab"
            tabindex="0">
            @include('frontend.member.dashboard.partials.file.partials.shared-file-list')
        </div>

        <div class="tab-pane fade show" id="all-file" role="tabpanel" aria-labelledby="all-file-tab"
            tabindex="0">
            @include('frontend.member.dashboard.partials.file.partials.file-list')
        </div>

        <div class="tab-pane fade " id="add-file" role="tabpanel" aria-labelledby="add-file-tab" tabindex="0">
            @include('frontend.member.dashboard.partials.file.partials.add-file')
        </div>
    </div>
</div>


