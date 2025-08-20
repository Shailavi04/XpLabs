@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">{{ $user->name }}'s Profile</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card profile-card overflow-hidden">
                    <div class="profile-image">
                        <img src="{{ asset('admin/assets/images/media/media-3.jpg') }}" class="card-img-top"
                            alt="Profile Image">
                    </div>
                    <div class="card-body p-4 pb-0 position-relative">
                        <span class="avatar avatar-xxl avatar-rounded bg-info online">
                            <img src="{{ $user->profile_image ? asset('uploads/profile/' . $user->profile_image) : asset('admin/assets/images/faces/4.jpg') }}"
                                alt="Avatar">

                        </span>
                        <div class="mt-4 mb-3 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                            <div>
                                <h5 class="fw-semibold mb-1">{{ $user->name }}</h5>
                                <span class="d-block fw-medium text-muted mb-1">{{ $user->role->name ?? 'No Role' }}</span>
                                <p class="fs-12 mb-0 fw-medium text-muted">
                                    <span class="me-3"></span>
                                </p>
                            </div>
                        </div>

                        <ul class="nav nav-tabs mb-0 tab-style-8 scaleX" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="profile-about-tab" data-bs-toggle="tab"
                                    data-bs-target="#profile-about-tab-pane" type="button" role="tab"
                                    aria-controls="profile-about-tab-pane" aria-selected="true">Profile</button>
                            </li>


                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3">
                <div class="card custom-card overflow-hidden">
                    <div class="card-header">
                        <div class="card-title">
                            Personal Info
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div><span class="fw-medium me-2">Name :</span><span
                                        class="text-muted">{{ $user->name }}</span></div>
                            </li>
                            <li class="list-group-item">
                                <div><span class="fw-medium me-2">Email :</span><span
                                        class="text-muted">{{ $user->email }}</span></div>
                            </li>
                            <li class="list-group-item">
                                <div><span class="fw-medium me-2">Phone :</span><span
                                        class="text-muted">{{ $user->phone_number }}</span></div>
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="card custom-card overflow-hidden">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Contact Info
                        </div>
                        <a href="javascript:void(0);" class="fs-12 text-muted"> View All<i
                                class="ti ti-arrow-narrow-right ms-1"></i> </a>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="text-muted">
                                    <p class="mb-2">
                                        <span class="avatar avatar-sm avatar-rounded text-info">
                                            <i class="ri-building-line align-middle fs-15"></i>
                                        </span>
                                        <span class="fw-medium text-default">Email: </span>
                                        {{ $user->email ?? 'N/A' }}
                                    </p>
                                    <p class="mb-0">
                                        <span class="avatar avatar-sm avatar-rounded text-warning">
                                            <i class="ri-map-pin-line align-middle fs-15"></i>
                                        </span>
                                        <span class="fw-medium text-default">Contact: </span>
                                        {{ $user->phone_number ?? 'N/A' }},

                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>


            </div>
            <div class="col-xl-9">
                <div class="tab-content" id="profile-tabs">
                    <div class="tab-pane show active p-0 border-0" id="profile-about-tab-pane" role="tabpanel"
                        aria-labelledby="profile-about-tab" tabindex="0">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body p-0">
                                <form action="{{ route('users.profile_update', $user->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <ul class="list-group list-group-flush">

                                        {{-- Common Fields for All Roles --}}
                                        <li class="list-group-item p-4">
                                            <span class="fw-medium fs-15 d-block mb-3">Personal Info :</span>
                                            <div class="row gy-4 align-items-center">


                                                <div class="col-xl-3">
                                                    <div class="lh-1">
                                                        <span class="fw-medium">Profile Image :</span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-9">
                                                    <input type="file" name="profile_image" class="form-control">


                                                </div>

                                                <div class="col-xl-3">
                                                    <label class="fw-medium">Name :</label>
                                                </div>
                                                <div class="col-xl-9">
                                                    <input type="text" name="name" class="form-control"
                                                        placeholder="Name" value="{{ old('name', $user->name ?? '') }}">
                                                </div>

                                                <div class="col-xl-3">
                                                    <label class="fw-medium">Email :</label>
                                                </div>
                                                <div class="col-xl-9">
                                                    <input type="email" name="email" class="form-control"
                                                        placeholder="Email"
                                                        value="{{ old('email', $user->email ?? '') }}">
                                                </div>

                                                <div class="col-xl-3">
                                                    <label class="fw-medium">Phone Number :</label>
                                                </div>
                                                <div class="col-xl-9">
                                                    <input type="text" name="phone_number" class="form-control"
                                                        placeholder="Phone Number"
                                                        value="{{ old('phone_number', $user->phone_number ?? '') }}">
                                                </div>

                                                <div class="col-xl-3">
                                                    <label class="fw-medium">Password :</label>
                                                </div>
                                                <div class="col-xl-9">
                                                    <input type="password" name="password" class="form-control"
                                                        placeholder="Password">
                                                </div>

                                            </div>
                                        </li>

                                        {{-- Role 2 Specific Fields --}}
                                        <li id="role2-fields" class="list-group-item p-4" style="display: none;">
                                            <div class="row gy-4 align-items-center">

                                                <div class="col-xl-3">
                                                    <label class="fw-medium">Country :</label>
                                                </div>
                                                <div class="col-xl-9">
                                                    <select name="country" class="form-control">
                                                        <option value="">Select Country</option>
                                                        <option value="India"
                                                            {{ optional($user->centers->first())->country == 'India' ? 'selected' : '' }}>
                                                            India</option>
                                                        <option value="USA"
                                                            {{ optional($user->centers->first())->country == 'USA' ? 'selected' : '' }}>
                                                            USA</option>
                                                        <option value="UK"
                                                            {{ optional($user->centers->first())->country == 'UK' ? 'selected' : '' }}>
                                                            UK</option>
                                                        <option value="Australia"
                                                            {{ optional($user->centers->first())->country == 'Australia' ? 'selected' : '' }}>
                                                            Australia</option>
                                                    </select>
                                                </div>

                                                <div class="col-xl-3">
                                                    <label class="fw-medium">State :</label>
                                                </div>
                                                <div class="col-xl-9">
                                                    <select name="state" class="form-control">
                                                        <option value="">Select State</option>
                                                        @php $state = optional($user->centers->first())->state; @endphp
                                                        <option value="Maharashtra"
                                                            {{ $state == 'Maharashtra' ? 'selected' : '' }}>Maharashtra
                                                        </option>
                                                        <option value="Delhi" {{ $state == 'Delhi' ? 'selected' : '' }}>
                                                            Delhi</option>
                                                        <option value="Karnataka"
                                                            {{ $state == 'Karnataka' ? 'selected' : '' }}>Karnataka
                                                        </option>
                                                        <option value="Tamil Nadu"
                                                            {{ $state == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu
                                                        </option>
                                                        <option value="Uttar Pradesh"
                                                            {{ $state == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col-xl-3">
                                                    <label class="fw-medium">City :</label>
                                                </div>
                                                <div class="col-xl-9">
                                                    <select name="city" class="form-control">
                                                        <option value="">Select City</option>
                                                        @php $city = optional($user->centers->first())->city; @endphp
                                                        <option value="Mumbai" {{ $city == 'Mumbai' ? 'selected' : '' }}>
                                                            Mumbai</option>
                                                        <option value="Pune" {{ $city == 'Pune' ? 'selected' : '' }}>
                                                            Pune</option>
                                                        <option value="New Delhi"
                                                            {{ $city == 'New Delhi' ? 'selected' : '' }}>New Delhi</option>
                                                        <option value="Bengaluru"
                                                            {{ $city == 'Bengaluru' ? 'selected' : '' }}>Bengaluru</option>
                                                        <option value="Chennai"
                                                            {{ $city == 'Chennai' ? 'selected' : '' }}>Chennai</option>
                                                        <option value="Lucknow"
                                                            {{ $city == 'Lucknow' ? 'selected' : '' }}>Lucknow</option>
                                                    </select>
                                                </div>

                                                <div class="col-xl-3">
                                                    <label class="fw-medium">Postal Code :</label>
                                                </div>
                                                <div class="col-xl-9">
                                                    <input type="text" name="postal_code" class="form-control"
                                                        placeholder="Postal Code"
                                                        value="{{ old('postal_code', optional($user->centers->first())->postal_code) }}">
                                                </div>

                                                <div class="col-xl-3">
                                                    <label class="fw-medium">Description :</label>
                                                </div>
                                                <div class="col-xl-9">
                                                    <textarea name="description" class="form-control" placeholder="Description" rows="3">{{ old('description', optional($user->centers->first())->description) }}</textarea>
                                                </div>

                                                <div class="col-xl-3">
                                                    <label class="fw-medium">Address :</label>
                                                </div>
                                                <div class="col-xl-9">
                                                    <input type="text" name="address" class="form-control"
                                                        placeholder="Address"
                                                        value="{{ old('address', optional($user->centers->first())->address) }}">
                                                </div>

                                                <div class="col-xl-3">
                                                    <label class="fw-medium">Code :</label>
                                                </div>
                                                <div class="col-xl-9">
                                                    <input type="text" name="code" class="form-control"
                                                        placeholder="Code"
                                                        value="{{ old('code', optional($user->centers->first())->code) }}">
                                                </div>

                                                <div class="col-xl-3">
                                                    <label class="fw-medium">Longitude :</label>
                                                </div>
                                                <div class="col-xl-9">
                                                    <input type="text" name="longitude" class="form-control"
                                                        placeholder="Longitude"
                                                        value="{{ old('longitude', optional($user->centers->first())->longitude) }}">
                                                </div>

                                                <div class="col-xl-3">
                                                    <label class="fw-medium">Latitude :</label>
                                                </div>
                                                <div class="col-xl-9">
                                                    <input type="text" name="latitude" class="form-control"
                                                        placeholder="Latitude"
                                                        value="{{ old('latitude', optional($user->centers->first())->latitude) }}">
                                                </div>

                                            </div>
                                        </li>

                                                                               
 <li id="role3-fields" class="list-group-item p-4" style="display: none;">
                                            <div class="row gy-4 align-items-center">

                                                <div class="col-xl-3">
                                                    <label class="fw-medium">Emergency Contact :</label>
                                                </div>
                                                <div class="col-xl-9">
                                                    <input type="text" name="emergency_contact" class="form-control"
                                                        value="{{ old('emergency_contact', $instructor->emergency_contact ?? '') }}">
                                                </div>

                                                <div class="col-xl-3">
                                                    <label class="fw-medium">Qualification :</label>
                                                </div>
                                                <div class="col-xl-9">
                                                    <input type="text" name="qualification" class="form-control"
                                                        value="{{ old('qualification', $instructor->qualification ?? '') }}">
                                                </div>

                                                <div class="col-xl-3">
                                                    <label class="fw-medium">Designation :</label>
                                                </div>
                                                <div class="col-xl-9">
                                                    <input type="text" name="designation" class="form-control"
                                                        value="{{ old('designation', $instructor->designation ?? '') }}">
                                                </div>

                                               

                                                <div class="col-xl-3">
                                                    <label class="fw-medium">Experience Years :</label>
                                                </div>
                                                <div class="col-xl-9">
                                                    <input type="number" name="experience_years" class="form-control"
                                                        value="{{ old('experience_years', $instructor->experience_years ?? '') }}">
                                                </div>

                                                <div class="col-xl-3">
                                                    <label class="fw-medium">Joining Date :</label>
                                                </div>
                                                <div class="col-xl-9">
                                                    <input type="date" name="joining_date" class="form-control"
                                                        value="{{ old('joining_date', $instructor->joining_date ?? '') }}">
                                                </div>

                                                <div class="col-xl-3">
                                                    <label class="fw-medium">Bio :</label>
                                                </div>
                                                <div class="col-xl-9">
                                                    <textarea name="bio" class="form-control" rows="3">{{ old('bio', $instructor->bio ?? '') }}</textarea>
                                                </div>

                                                <div class="col-xl-3">
                                                    <label class="fw-medium">Active :</label>
                                                </div>
                                                <div class="col-xl-9">
                                                    <select name="active" class="form-control">
                                                        <option value="1"
                                                            {{ ($instructor->active ?? 0) == 1 ? 'selected' : '' }}>Active
                                                        </option>
                                                        <option value="0"
                                                            {{ ($instructor->active ?? 0) == 0 ? 'selected' : '' }}>
                                                            Inactive</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </li>

                                          


                                      


                                        <div class="card-body">t7ju45ehgndf
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>

                                    </ul>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
let roleId = {{ $user->role_id }};
            let role2Fields = document.getElementById("role2-fields");
            let role3Fields = document.getElementById("role3-fields");

            if (roleId == 2) {
                role2Fields.style.display = "block";
            } else {
                role2Fields.style.display = "none";
            }

            if (roleId == 3) {

                role3Fields.style.display = "block";
            } else {
                role3Fields.style.display = "none";

            }
           




        });
    </script>
@endpush
