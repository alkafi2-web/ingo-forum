@extends('admin.layouts.backend-layout')
@section('breadcame')
Dashboard
@endsection
@section('admin-content')
<div class="row g-5 das_board">
  {{-- Left Side  --}}
  <div class="col-lg-6">
    <div class="row g-5">
      <div class="col-12">
        <div class="card">
          <div class="card-header pt-5">
            <h3 class="card-label fw-bold text-gray-900">Member</h3>
          </div>
          <div class="card-body pt-5">
            <div class="row gx-3">
                <div class="col-4">
                    <div class="d-flex flex-column bg-light-primary px-6 py-8 rounded-2 h-lg-100">
                        <i class="fas fa-users fs-2x text-primary my-2"></i>
                        <span class="text-primary fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 mt-3">{{ $totalMembers }}</span>
                        <a href="#" class="text-primary fw-semibold fs-5">Total Members</a>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex flex-column bg-light-success px-6 py-8 rounded-2 h-lg-100">
                        <i class="fas fa-user-check fs-2x text-success my-2"></i>
                        <span class="text-success fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 mt-3">{{ $activeMembers }}</span>
                        <a href="#" class="text-success fw-semibold fs-5">Active Members</a>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex flex-column bg-light-danger px-6 py-8 rounded-2 h-lg-100">
                        <i class="fas fa-exclamation-circle fs-2x text-danger my-2"></i>
                        <span class="text-danger fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 mt-3">{{ $memberRequests }}</span>
                        <a href="#" class="text-danger fw-semibold fs-5">Member Requests</a>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card">
            <div class="card-header pt-5">
                <h3 class="card-label fw-bold text-gray-900">Newest Members</h3>
            </div>
            <div class="card-body pt-5">
                @forelse($latestMembers as $member)
                <div class="d-flex align-items-center mb-4">
                    <div class="symbol symbol-50px me-5">
                      <img src="{{ asset('public/frontend/images/member/' . ($member->info->logo ?? 'placeholder.jpg')) }}" alt="user" />
                    </div>
                    <div class="flex-grow-1">
                        <a href="{{ route('member.view', ['id' => $member->id]) }}" class="text-gray-900 fw-bold text-hover-primary fs-6">{{ $member->info->organisation_name }}</a>
                        <span class="text-muted d-block fw-bold">
                            <i class="fas fa-calendar-day"></i> {{ $member->created_at->format('d/m/Y') }} &nbsp; 
                            <i class="fas fa-id-card"></i> {{ $member->info->membership_id }}
                        </span>
                    </div>
                </div>
                @empty
                <p class="text-center">No members available</p>
                @endforelse
            </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-header pt-5 align-items-center">
            <h3 class="card-label fw-bold text-gray-900 mb-0">Latest Event</h3>
            <a href="" class="btn btn-sm fw-bold btn-primary">
              Add New</a>
          </div>
          <div class="card-body pt-5">
            <div class="d-flex flex-stack">
              <div class="d-flex align-items-center me-3">
                <div class="symbol symbol-50px me-5">
                  <img src="{{ asset('public/admin/media/avatars/150-26.jpg') }}" alt="user" />
                </div>
                <div class="flex-grow-1">
                  <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Laravel</a>
                  <span class="text-gray-500 fw-semibold d-block fs-6">02/03/2020</span>
                </div>
              </div>
              <a href=""
                class="btn btn-icon btn-sm h-auto btn-color-gray-500 btn-active-color-primary justify-content-end">
                <i class="fas fa-external-link-alt"></i></a>
            </div>
            <div class="separator separator-dashed my-2"></div>
            <div class="d-flex flex-stack">
              <div class="d-flex align-items-center me-3">
                <div class="symbol symbol-50px me-5">
                  <img src="{{ asset('public/admin/media/avatars/150-26.jpg') }}" alt="user" />
                </div>
                <div class="flex-grow-1">
                  <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Laravel</a>
                  <span class="text-gray-500 fw-semibold d-block fs-6">02/03/2020</span>
                </div>
              </div>
              <a href=""
                class="btn btn-icon btn-sm h-auto btn-color-gray-500 btn-active-color-primary justify-content-end">
                <i class="fas fa-external-link-alt"></i></a>
            </div>
            <div class="separator separator-dashed my-2"></div>
            <div class="d-flex flex-stack">
              <div class="d-flex align-items-center me-3">
                <div class="symbol symbol-50px me-5">
                  <img src="{{ asset('public/admin/media/avatars/150-26.jpg') }}" alt="user" />
                </div>
                <div class="flex-grow-1">
                  <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Laravel</a>
                  <span class="text-gray-500 fw-semibold d-block fs-6">02/03/2020</span>
                </div>
              </div>
              <a href=""
                class="btn btn-icon btn-sm h-auto btn-color-gray-500 btn-active-color-primary justify-content-end">
                <i class="fas fa-external-link-alt"></i></a>
            </div>
            <div class="separator separator-dashed my-2"></div>
            <div class="d-flex flex-stack">
              <div class="d-flex align-items-center me-3">
                <div class="symbol symbol-50px me-5">
                  <img src="{{ asset('public/admin/media/avatars/150-26.jpg') }}" alt="user" />
                </div>
                <div class="flex-grow-1">
                  <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Laravel</a>
                  <span class="text-gray-500 fw-semibold d-block fs-6">02/03/2020</span>
                </div>
              </div>
              <a href=""
                class="btn btn-icon btn-sm h-auto btn-color-gray-500 btn-active-color-primary justify-content-end">
                <i class="fas fa-external-link-alt"></i></a>
            </div>
            <div class="separator separator-dashed my-2"></div>
            <div class="d-flex flex-stack">
              <div class="d-flex align-items-center me-3">
                <div class="symbol symbol-50px me-5">
                  <img src="{{ asset('public/admin/media/avatars/150-26.jpg') }}" alt="user" />
                </div>
                <div class="flex-grow-1">
                  <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Laravel</a>
                  <span class="text-gray-500 fw-semibold d-block fs-6">02/03/2020</span>
                </div>
              </div>
              <a href=""
                class="btn btn-icon btn-sm h-auto btn-color-gray-500 btn-active-color-primary justify-content-end">
                <i class="fas fa-external-link-alt"></i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-header pt-5 align-items-center">
            <h3 class="card-label fw-bold text-gray-900 mb-0">User Activity</h3>
            <a href="" class="btn btn-sm fw-bold btn-primary">
              Add New</a>
          </div>
          <div class="card-body pt-5">
            <div class="row mb-3">
              <div class="col-md-6 mb-3 mb-md-0">
                <div class="d-flex flex-stack">
                  <div class="d-flex align-items-center me-3">
                    <div class="user-activity me-5">
                      <i class="fas fa-user usr-active text-primary"></i>
                    </div>
                    <div class="flex-grow-1">
                      <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Active Clients</a>
                      <span class="text-gray-500 fw-semibold d-block fs-6"><span class="fs-2 text-primary">3</span> Active</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="d-flex flex-stack">
                  <div class="d-flex align-items-center me-3">
                    <div class="user-activity me-5 usr-online">
                      <i class="fas fa-user-check text-success"></i>
                    </div>
                    <div class="flex-grow-1">
                      <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Users Online</a>
                      <span class="text-gray-500 fw-semibold d-block fs-6"><span class="fs-2 text-success">3</span> Last Hour</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex align-items-center bg-light-success rounded p-3 mb-3">
              <div class="flex-grow-1 me-2">
                <a href="#" class="fw-bold text-gray-800 text-hover-primary fs-6">Navigation optimization</a>
                  <span class="text-muted fw-semibold d-block">Due in 2 Days</span>
              </div>
              <span class="fw-bold text-success py-1">22 Minutes ago</span>
            </div>
            <div class="d-flex align-items-center bg-light-success rounded p-3 mb-3">
              <div class="flex-grow-1 me-2">
                <a href="#" class="fw-bold text-gray-800 text-hover-primary fs-6">Navigation optimization</a>
                  <span class="text-muted fw-semibold d-block">Due in 2 Days</span>
              </div>
              <span class="fw-bold text-success py-1">22 Minutes ago</span>
            </div>
            <div class="d-flex align-items-center bg-light-success rounded p-3 mb-3">
              <div class="flex-grow-1 me-2">
                <a href="#" class="fw-bold text-gray-800 text-hover-primary fs-6">Navigation optimization</a>
                  <span class="text-muted fw-semibold d-block">Due in 2 Days</span>
              </div>
              <span class="fw-bold text-success py-1">22 Minutes ago</span>
            </div>
            <div class="d-flex align-items-center bg-light-success rounded p-3 mb-3">
              <div class="flex-grow-1 me-2">
                <a href="#" class="fw-bold text-gray-800 text-hover-primary fs-6">Navigation optimization</a>
                  <span class="text-muted fw-semibold d-block">Due in 2 Days</span>
              </div>
              <span class="fw-bold text-success py-1">22 Minutes ago</span>
            </div>
            <div class="d-flex align-items-center bg-light-success rounded p-3 mb-3">
              <div class="flex-grow-1 me-2">
                <a href="#" class="fw-bold text-gray-800 text-hover-primary fs-6">Navigation optimization</a>
                  <span class="text-muted fw-semibold d-block">Due in 2 Days</span>
              </div>
              <span class="fw-bold text-success py-1">22 Minutes ago</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- Right Side  --}}
  <div class="col-lg-6">
    <div class="row g-5">
      <div class="col-12">
        <div class="card">
            <div class="card-header pt-5">
                <h3 class="card-label fw-bold text-gray-900">Contact Request</h3>
            </div>
            <div class="card-body pt-5">
                <div class="row gx-3">
                    <div class="col-4">
                        <div class="d-flex flex-column bg-light-info px-6 py-8 rounded-2 h-lg-100">
                            <i class="fas fa-address-book fs-2x text-info my-2"></i>
                            <span class="text-info fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 mt-3">{{ $totalContactRequests }}</span>
                            <a href="#" class="text-info fw-semibold fs-5">Total Requests</a>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex flex-column bg-light-dark px-6 py-8 rounded-2 h-lg-100">
                            <i class="fas fa-calendar-day fs-2x text-dark my-2"></i>
                            <span class="text-dark fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 mt-3">{{ $todayContactRequests }}</span>
                            <a href="#" class="text-dark fw-semibold fs-5">Today Requests</a>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex flex-column bg-light-warning px-6 py-8 rounded-2 h-lg-100">
                            <i class="fas fa-calendar-day fs-2x text-warning my-2"></i>
                            <span class="text-warning fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 mt-3">{{ $currentMonthContactRequests }}</span>
                            <a href="#" class="text-warning fw-semibold fs-5">Current Month Requests</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="col-12">
          <div class="card">
              <div class="card-header pt-5 align-items-center">
                  <h3 class="card-label fw-bold text-gray-900 mb-0">Latest Post</h3>
                  <a href="{{ route('post.create') }}" class="btn btn-sm fw-bold btn-primary">Add New</a>
              </div>
              <div class="card-body pt-5">
                  @forelse($latestPosts as $post)
                  <div class="d-flex align-items-center mb-5">
                      <span class="bullet bullet-vertical h-40px bg-primary"></span>
                      <div class="flex-grow-1 mx-3">
                          <a href="{{ route('single.post', ['categorySlug' => $post->category->slug, 'postSlug' => $post->slug]) }}" class="text-gray-800 text-hover-primary fw-bold fs-6">{{ $post->title }}</a>
                          <span class="text-muted fw-semibold d-block">
                              <div class="post-overview">
                                  <i class="fas fa-comments text-primary"></i>&nbsp;
                                  <small style="color: #999">
                                      {{ $post->total_comments_and_replies }}
                                  </small> &nbsp;&nbsp;
                                  <i class="fas fa-book-reader text-success"></i> &nbsp;
                                  <small style="color: #999">{{ $post->total_reads }}</small> &nbsp;
                              </div>
                          </span>
                      </div>
                      <a href="{{ route('single.post', ['categorySlug' => $post->category->slug, 'postSlug' => $post->slug]) }}" class="badge badge-light-primary fs-8 fw-bold"><i class="fas fa-external-link-alt text-primary"></i></a>
                  </div>
                  @empty
                  <p class="text-center">No posts available</p>
                  @endforelse
              </div>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection