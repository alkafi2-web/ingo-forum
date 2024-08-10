@extends('frontend.member.dashboard.layout')

@section('member-dashboard')
<div class="member-dashboard">
   <!-- Main Content -->
   <div class="container">
      <div class="row">
         <div class="col-md-4">
               <div class="card">
                  <i class="fas fa-calendar-alt calender-icon"></i>
                  <h4 class="mt-2">Events</h4>
                  <p class="fw-bold">{{ $events->count() }}</p>
               </div>
         </div>
         <div class="col-md-4">
               <div class="card">
                  <i class="far fa-newspaper"></i>
                  <h4 class="mt-2">Posts</h4>
                  <p class="fw-bold">{{ $posts->count() }}</p>
               </div>
         </div>
         <div class="col-md-4">
               <div class="card">
                  <i class="fas fa-file-pdf"></i>
                  <h4 class="mt-2">Publications</h4>
                  <p class="fw-bold">{{ $publications->count() }}</p>
               </div>
         </div>
      </div>

      <div class="row chart-container">
         <div class="col-md-6">
            <h6>Most Joined Event</h6>
               <canvas id="joinedByEventChart"></canvas>
         </div>
         <div class="col-md-6">
            <h6>Most Read Post</h6>
               <canvas id="topReadPosts"></canvas>
         </div>
      </div>

      <!-- Pie chart for Status -->
      <div class="row chart-container">
         <div class="col-md-4">
            <h6>Event Status</h6>
               <canvas id="eventStatusPie"></canvas>
         </div>
         <div class="col-md-4">
            <h6>Post Status</h6>
               <canvas id="postStatusPie"></canvas>
         </div>
         <div class="col-md-4">
            <h6>Publications Status</h6>
               <canvas id="publicationStatusPie"></canvas>
         </div>
      </div>
   </div>
</div>

@push('custom-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4"></script>
<script>
   // Data for charts
   var joinedByEventChartData = {
      labels: @json($eventLabels),
      datasets: [{
         label: "Event Joined",
         data: @json($eventParticipantsCounts),
         backgroundColor: ["#007BFF", "#28A745", "#FFC107", "#DC3545", "#FF00FF"],
      }]
   };

   var topReadPostsData = {
      labels: @json($postLabels),
      datasets: [{
         label: "Post Read",
         data: @json($postReadCounts),
         backgroundColor: ["#007BFF", "#28A745", "#FFC107", "#DC3545", "#FF5733"],
      }]
   };

   var eventStatusPieData = {
      labels: ["Approved", "Rejected", "Suspended", "Pending"],
      datasets: [{
         data: [
            {{ $eventStatusCounts[1] ?? 0 }},
            {{ $eventStatusCounts[3] ?? 0 }},
            {{ $eventStatusCounts[2] ?? 0 }},
            {{ $eventStatusCounts[0] ?? 0 }}
         ],
         backgroundColor: ["#28A745", "#FFC107", "#007BFF", "#FF5733"],
      }]
   };

   var postStatusPieData = {
      labels: ["Approved", "Rejected", "Suspended", "Pending"],
      datasets: [{
         data: [
            {{ $postStatusCounts[1] ?? 0 }},
            {{ $postStatusCounts[3] ?? 0 }},
            {{ $postStatusCounts[2] ?? 0 }},
            {{ $postStatusCounts[0] ?? 0 }}
         ],
         backgroundColor: ["#28A745", "#FFC107", "#007BFF", "#FF5733"],
      }]
   };

   var publicationStatusPieData = {
      labels: ["Approved", "Rejected", "Suspended", "Pending"],
      datasets: [{
         data: [
            {{ $publicationStatusCounts[1] ?? 0 }},
            {{ $publicationStatusCounts[3] ?? 0 }},
            {{ $publicationStatusCounts[2] ?? 0 }},
            {{ $publicationStatusCounts[0] ?? 0 }}
         ],
         backgroundColor: ["#28A745", "#FFC107", "#007BFF", "#FF5733"],
      }]
   };

   // Initialize charts
   var joinedByEventChart = new Chart(document.getElementById("joinedByEventChart"), {
      type: "bar",
      data: joinedByEventChartData,
   });

   var topReadPosts = new Chart(document.getElementById("topReadPosts"), {
      type: "horizontalBar",
      data: topReadPostsData,
   });

   var eventStatusPie = new Chart(document.getElementById("eventStatusPie"), {
      type: "pie",
      data: eventStatusPieData,
   });

   var postStatusPie = new Chart(document.getElementById("postStatusPie"), {
      type: "pie",
      data: postStatusPieData,
   });

   var publicationStatusPie = new Chart(document.getElementById("publicationStatusPie"), {
      type: "pie",
      data: publicationStatusPieData,
   });
</script>
@endpush
@endsection
