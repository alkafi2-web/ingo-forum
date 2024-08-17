
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link fw-bold active" id="elements-tab" data-bs-toggle="tab" data-bs-target="#elements" role="tab" aria-controls="elements" aria-selected="true"><i class="fab fa-elementor"></i>&nbsp;Elements</a>
    </li>
    <li class="nav-item">
        <a class="nav-link fw-bold" id="style-tab" data-bs-toggle="tab" data-bs-target="#style" role="tab" aria-controls="style" aria-selected="true"><i class="fas fa-palette"></i>&nbsp; Style</a>
    </li>
</ul>
<div class="tab-content mt-2" id="pills-tabContent">
    <div class="tab-pane fade show active" id="elements" role="tabpanel" aria-labelledby="layout-tab" tabindex="0"><div class="accordion" id="accordionElements">
        <div class="accordion-item">
            <h2 class="accordion-header" id="accordion-one">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#container" aria-expanded="true" aria-controls="container">
                <i class="fas fa-th-large"></i>&nbsp; Layout
            </button>
            </h2>
            <div id="container" class="accordion-collapse collapse show" aria-labelledby="accordion-one" data-bs-parent="#accordionElements">
            <div class="accordion-body">
                <div class="row g-3 align-items-center">
                    <div class="col-12">
                        <div class="builder-panel-category-items builder-responsive-panel">
                            <div class="builder-element-wrapper">
                                <button class="builder-element active" draggable="true">
                                    <div class="icon">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <div class="title-wrapper">
                                        <div class="title">Container</div>
                                    </div>
                                </button>
                            </div>
                            <div class="builder-element-wrapper d-none">
                                <button class="builder-element" draggable="true">
                                    <div class="icon">
                                        <i class="fas fa-th-large"></i>&nbsp;
                                    </div>
                                    <div class="title-wrapper">
                                        <div class="title">Grid</div>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <div class="row-class mt-3">
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-6">
                                    <label for="inputRowClass" class="col-form-label">Row Class</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" id="inputRowClass" class="form-control">
                                </div>
                            </div>
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-6">
                                    <label for="inputNumOfCoumn" class="col-form-label">No. of Column</label>
                                </div>
                                <div class="col-6">
                                    <input type="number" id="inputNumOfCoumn" class="form-control" min="1" max="4" aria-describedby="numberHelpInline">
                                </div>
                            </div>
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-6">
                                    <label for="inputColumnClass" class="col-form-label">1st Col Class</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" id="inputColumnClass" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Accordion Item #2
            </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionElements">
            <div class="accordion-body">
                <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
            </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Accordion Item #3
            </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionElements">
            <div class="accordion-body">
                <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
            </div>
            </div>
        </div>
        </div>
    </div>
    <div class="tab-pane fade show" id="style" role="tabpanel" aria-labelledby="style-tab" tabindex="0">
        this is style
    </div>
</div>
@push('custom-js')
    <script>
        
    </script>
@endpush