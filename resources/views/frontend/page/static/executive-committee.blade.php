@extends('frontend.layouts.frontend-page-layout')
@section('frontend-section')
@section('page-title', 'Executive committee')
<section class="ptb-50 executive-committee">
  <div class="container">
    <div class="row mb-4">
      <div class="col-12">
        <div class="member-card">
          <div class="d-flex align-items-center mb-2 member-card-profile-info">
            <img src="{{ asset('public/frontend/images/Hasin Jahan.jpg')}}" alt="Ms Hasin Jahan"
              class="member-image me-2">
            <div>
              <h3>Ms Hasin Jahan</h3>
              <h4>Convener</h4>
              <h5>Country Director, WaterAid Bangladesh</h5>
            </div>
          </div>
          <p class="member-desc"><strong>Description:</strong></p>
          <p>Hasin Jahan is a development professional specialising in water, sanitation, waste management, energy,
            and agricultural sectors. She leads the Bangladesh Country Programme of WaterAid. Her expertise includes
            managing large-scale projects in challenging contexts, such as the Rohingya response, and mobilizing
            resources effectively.</p>
          <p>Previously, she served as the Bangladesh Country Director for Practical Action and worked with the Local
            Government Engineering Department, ITN-BUET, World Bank, and DANIDA. Hasin is known for promoting
            innovative agricultural technologies, urban rainwater harvesting, public toilets, water safety plans,
            faecal sludge management, integrated waste management, and ICT-based outreach platforms.</p>
          <p>As convener for the INGO Forum, she continues to drive impactful initiatives and foster collaborative
            efforts in development sectors.</p>
        </div>
      </div>
      <div class="col-12">
        <div class="member-card">
          <div class="d-flex align-items-center mb-2 member-card-profile-info">
            <img src="{{ asset('public/frontend/images/Ashish Demble.jpg')}}"
              alt="Mr Ashish Damle" class="member-image me-2">
            <div>
              <h3>Mr Ashish Damle</h3>
              <h4>Co-Convener</h4>
              <h5>Country Director, Oxfam Bangladesh</h5>
            </div>
          </div>
          <p class="member-desc"><strong>Description:</strong></p>
          <p>Ashish Damle is a social impact entrepreneur and champion change manager with 24 years of experience,
            including 17 years in international leadership roles. He is a global expert on human trafficking, child
            protection, missing children, IDPs, bonded and forced labor, and refugees. Ashish has served as Country
            Director for Oxfam International in Bangladesh and Afghanistan, and War Child UK in Afghanistan.</p>
          <p>With advanced skills in grant management, strategy development, and policy analysis, Ashish has
            successfully led teams and managed complex humanitarian programs in challenging environments. An
            accomplished public speaker, he has been invited to international forums such as the World Youth Congress,
            INTERPOL Global Conference, and SAARC Law Conference. Currently, Ashish serves as a co-convener for the
            INGO Forum.</p>
        </div>
      </div>
    </div>
    </div>
  </div>
</section>
@endsection