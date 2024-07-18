@extends('frontend.layouts.frontend-page-layout')
@section('page-title', 'Our Mmebers')
@section('frontend-section')

    <!-- Partners Area start here  -->
    <section class="ptb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <h2 class="section-title">Institutional Funding Partners</h2>
                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>
            <div class="row pt-5">
                <div class="partners">
                    @forelse ($membersInfos as $member)
                        <div class="partner d-flex flex-column">
                            <img src="{{ asset('public/frontend/images/member/') }}/{{ $member->logo ?? 'logo.png' }}"
                                alt="" class="mb-3">
                            <a href="{{ route('frontend.member.show', ['membership_id' => $member->membership_id]) }}"
                                class="partner-btn">View Profile</a>
                        </div>
                    @empty
                        <div class="text-center">
                            <h2>There is NO Member Join Yet</h2>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <!-- Partners Area end here  -->
@endsection
