@extends('frontend.layouts.frontend-page-layout')
@section('frontend-section')
@section('page-title', 'About Us')
<!-- About Us Section Start  -->
<section class="about-us-section pb-50">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <div class="fixtures">
          <div class="row gx-4 gy-5">
            
            <div class="col-6">
              <div class="fixtures-item fx1">
                <div class="fixture-icon">
                  <img src="{{ asset('public/frontend/images/icons/fx1.png') }}" alt="">
                </div>
                <div class="fixture-text">
                  <h3>Coordination</h3>
                  <span>The Forum Secretariat facilitates information sharing and mutual
                    understanding among our members.</span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="fixtures-item fx2">
                <div class="fixture-icon">
                  <img src="{{ asset('public/frontend/images/icons/fx3.png') }}" alt="">
                </div>
                <div class="fixture-text">
                  <h3>Advocacy</h3>
                  <span>We mobilise the INGO Forum members on collective positioning on critical
                    humanitarian issues.</span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="fixtures-item fx3">
                <div class="fixture-icon">
                  {{-- <img src="images/icons/fx4.png" alt=""> --}}
                  <img src="{{ asset('public/frontend/images/icons/fx4.png') }}" alt="">
                </div>
                <div class="fixture-text">
                  <h3>Safety and security</h3>
                  <span>The members of the INGO Forum are convinced that security, safety and
                    well-being of humanitarian personnel prevail.</span>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="fixtures-item fx4">
                <div class="fixture-icon">
                  <img src="{{ asset('public/frontend/images/icons/fx2.png') }}" alt="">
                  {{-- <img src="images/icons/fx2.png" alt=""> --}}
                </div>
                <div class="fixture-text">
                  <h3>Liaison with national NGOs</h3>
                  <span>The INGO members are committed to strengthening relationships, linkages
                    and collaborative efforts .</span>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="col-lg-6 ps-lg-5 mt-4 mt-lg-0">
        <div class="about-text add-list-style">
          <h5 class="sub-title">About Us</h5>
          <h2 class="section-title">What is INGO Forum
          </h2>
          <h4>The INGO Forum is a platform for International Non-Governmental Organizations (INGOs) working in Bangladesh</h4>
          <p>
            </p><p>The INGO Forum is a platform for International Non-Governmental Organizations (INGOs) working in Bangladesh. Established in response to the evolving needs of the development sector, the forum's mission is to:</p><ul><li>Facilitate information exchange and collaboration among INGOs to improve their practices and jointly influence development efforts.</li><li>Work towards maximizing impact through collaborative approaches and establishing common ground on best practices.</li><li>Engage with the Government of Bangladesh on issues concerning INGOs.</li><li>Promote transparency, accountability, and adherence to the SDGs in the work of INGOs within Bangladesh.</li></ul>
          <p></p>
          
        </div>
      </div>
    </div>
  </div>
</section>
<!-- About Us Section End  -->
<section class="ptb-50 bg-gray img-text-content">
  <div class="container">
    <div class="row d-flex align-items-center">
      <div class="col-md-6 img-text-left">
        <h2 class="section-title">Organisational History</h2>
        <p>The INGO Forum emerged in the late 2000s as a need for a separate platform for INGOs became evident. This arose from a shift in the national coordination mechanism for development agencies and the government's revision of the Foreign Donations (Voluntary Activities) Regulation Act.</p>
        <p>Initially, the forum focused on providing input on the act's revision and establishing its own structure and membership criteria. A significant event in 2011 solidified the forum's presence - a collaborative celebration of Bangladesh's independence with partner national NGOs.</p>
      </div>
      <div class="col-md-6 img-text-right">
        <img class="img-text-content-img" src="{{ asset('public/frontend/images/history-img.png') }}" alt="">
      </div>
    </div>
  </div>
</section>
@endsection
