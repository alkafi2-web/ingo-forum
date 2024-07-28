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
                  <i class="fas fa-hand-holding-medical fs-2x text-primary my-2"></i>
                  <span class="text-primary fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 mt-3">25</span>
                  <a href="#" class="text-primary fw-semibold fs-5">Total</a>
                </div>
              </div>
              <div class="col-4">
                <div class="d-flex flex-column bg-light-success px-6 py-8 rounded-2 h-lg-100">
                  <i class="fas fa-user-check fs-2x text-success my-2"></i>
                  <span class="text-success fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 mt-3">8</span>
                  <a href="#" class="text-success fw-semibold fs-5">Active</a>
                </div>
              </div>
              <div class="col-4">
                <div class=" d-flex flex-column bg-light-danger px-6 py-8 rounded-2 h-lg-100">
                  <i class="fas fa-exclamation-circle fs-2x text-danger my-2"></i>
                  <span class="text-danger fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 mt-3">5</span>
                  <a href="#" class="text-danger fw-semibold fs-5">Request</a>
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
            <div class="d-flex align-items-center mb-4">
              <div class="symbol symbol-50px me-5">
                <img src="{{ asset('public/admin/media/avatars/150-26.jpg') }}" alt="user" />
              </div>
              <div class="flex-grow-1">
                <a href="#" class="text-gray-900 fw-bold text-hover-primary fs-6">Emma Smith</a>
                <span class="text-muted d-block fw-bold">12/072023</span>
              </div>
            </div>
            <div class="d-flex align-items-center mb-4">
              <div class="symbol symbol-50px me-5">
                <img src="{{ asset('public/admin/media/avatars/150-26.jpg') }}" alt="user" />
              </div>
              <div class="flex-grow-1">
                <a href="#" class="text-gray-900 fw-bold text-hover-primary fs-6">Sean Bean</a>
                <span class="text-muted d-block fw-bold">01/03/2023</span>
              </div>
            </div>
            <div class="d-flex align-items-center mb-4">
              <div class="symbol symbol-50px me-5">
                <img src="{{ asset('public/admin/media/avatars/150-26.jpg') }}" alt="user" />
              </div>
              <div class="flex-grow-1">
                <a href="#" class="text-gray-900 fw-bold text-hover-primary fs-6">Brian Cox</a>
                <span class="text-muted d-block fw-bold">12/072023</span>
              </div>
            </div>
            <div class="d-flex align-items-center mb-4">
              <div class="symbol symbol-50px me-5">
                <img src="{{ asset('public/admin/media/avatars/150-26.jpg') }}" alt="user" />
              </div>
              <div class="flex-grow-1">
                <a href="#" class="text-gray-900 fw-bold text-hover-primary fs-6">Francis Mitcham</a>

                <span class="text-muted d-block fw-bold">01/03/2023</span>
              </div>
            </div>
            <div class="d-flex align-items-center">
              <div class="symbol symbol-50px me-5">
                <img src="{{ asset('public/admin/media/avatars/150-26.jpg') }}" alt="user" />
              </div>
              <div class="flex-grow-1">
                <a href="#" class="text-gray-900 fw-bold text-hover-primary fs-6">Dan Wilson</a>
                <span class="text-muted d-block fw-bold">12/072023</span>
              </div>
            </div>
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
            <h3 class="card-label fw-bold text-gray-900">Quick Setting</h3>
          </div>
          <div class="card-body pt-5">
            <div class="row gx-3">
              <div class="col-4">
                <div class="d-flex flex-column bg-light-primary px-6 py-8 rounded-2 h-lg-100">
                  <i class="fas fa-hand-holding-medical fs-2x text-primary my-2"></i>
                  <span class="text-primary fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 mt-3">25</span>
                  <a href="#" class="text-primary fw-semibold fs-5">Total</a>
                </div>
              </div>
              <div class="col-4">
                <div class="d-flex flex-column bg-light-success px-6 py-8 rounded-2 h-lg-100">
                  <i class="fas fa-user-check fs-2x text-success my-2"></i>
                  <span class="text-success fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 mt-3">8</span>
                  <a href="#" class="text-success fw-semibold fs-5">Active</a>
                </div>
              </div>
              <div class="col-4">
                <div class=" d-flex flex-column bg-light-danger px-6 py-8 rounded-2 h-lg-100">
                  <i class="fas fa-exclamation-circle fs-2x text-danger my-2"></i>
                  <span class="text-danger fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 mt-3">5</span>
                  <a href="#" class="text-danger fw-semibold fs-5">Request</a>
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
            <a href="" class="btn btn-sm fw-bold btn-primary">
              Add New</a>
          </div>
          <div class="card-body pt-5">
            <div class="d-flex align-items-center mb-8">
              <span class="bullet bullet-vertical h-40px bg-primary"></span>
              <div class="flex-grow-1 mx-3">
                <a href="#" class="text-gray-800 text-hover-primary fw-bold fs-6">Stakeholder Meeting</a>
                <span class="text-muted fw-semibold d-block">Due in 3 Days</span>
              </div>
              <span class="badge badge-light-primary fs-8 fw-bold"><i class="fas fa-external-link-alt text-primary"></i></span>
            </div>
            <div class="d-flex align-items-center mb-8">
              <span class="bullet bullet-vertical h-40px bg-primary"></span>
              <div class="flex-grow-1 mx-3">
                <a href="#" class="text-gray-800 text-hover-primary fw-bold fs-6">Stakeholder Meeting</a>
                <span class="text-muted fw-semibold d-block">Due in 3 Days</span>
              </div>
              <span class="badge badge-light-primary fs-8 fw-bold"><i class="fas fa-external-link-alt text-primary"></i></span>
            </div>
            <div class="d-flex align-items-center mb-8">
              <span class="bullet bullet-vertical h-40px bg-primary"></span>
              <div class="flex-grow-1 mx-3">
                <a href="#" class="text-gray-800 text-hover-primary fw-bold fs-6">Stakeholder Meeting</a>
                <span class="text-muted fw-semibold d-block">Due in 3 Days</span>
              </div>
              <span class="badge badge-light-primary fs-8 fw-bold"><i class="fas fa-external-link-alt text-primary"></i></span>
            </div>
            <div class="d-flex align-items-center mb-8">
              <span class="bullet bullet-vertical h-40px bg-primary"></span>
              <div class="flex-grow-1 mx-3">
                <a href="#" class="text-gray-800 text-hover-primary fw-bold fs-6">Stakeholder Meeting</a>
                <span class="text-muted fw-semibold d-block">Due in 3 Days</span>
              </div>
              <span class="badge badge-light-primary fs-8 fw-bold"><i class="fas fa-external-link-alt text-primary"></i></span>
            </div>
            <div class="d-flex align-items-center mb-8">
              <span class="bullet bullet-vertical h-40px bg-primary"></span>
              <div class="flex-grow-1 mx-3">
                <a href="#" class="text-gray-800 text-hover-primary fw-bold fs-6">Stakeholder Meeting</a>
                <span class="text-muted fw-semibold d-block">Due in 3 Days</span>
              </div>
              <span class="badge badge-light-primary fs-8 fw-bold"><i class="fas fa-external-link-alt text-primary"></i></span>
            </div>
            <div class="d-flex align-items-center mb-8">
              <span class="bullet bullet-vertical h-40px bg-primary"></span>
              <div class="flex-grow-1 mx-3">
                <a href="#" class="text-gray-800 text-hover-primary fw-bold fs-6">Stakeholder Meeting</a>
                <span class="text-muted fw-semibold d-block">Due in 3 Days</span>
              </div>
              <span class="badge badge-light-primary fs-8 fw-bold"><i class="fas fa-external-link-alt text-primary"></i></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection