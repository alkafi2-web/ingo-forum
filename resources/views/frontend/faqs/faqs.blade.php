@extends('frontend.layouts.frontend-page-layout')
@section('page-title')
    FAQs
@endsection
@section('frontend-section')
    <!-- FAQ Area start here -->
    <section class="faq-section ptb-50">
        <div class="container">
            <div class="faq-card">
                <div class="row">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <div class="nav nav-pills faq-items h-100" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            @foreach ($faqs as $index => $faq)
                                <button class="nav-link {{ $index == 0 ? 'active' : '' }}"
                                    id="v-pills-tab-{{ $index }}-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-tab-{{ $index }}" type="button" role="tab"
                                    aria-controls="v-pills-tab-{{ $index }}"
                                    aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                                    {{ $faq->question }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content faq-content" id="v-pills-tabContent">
                            @foreach ($faqs as $index => $faq)
                                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                    id="v-pills-tab-{{ $index }}" role="tabpanel"
                                    aria-labelledby="v-pills-tab-{{ $index }}-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-12">
                                            {{-- <h3>{{ $faq->question }}</h3> --}}
                                            <p class="fs-4">{!! $faq->answer !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- FAQ Area end here -->
@endsection
