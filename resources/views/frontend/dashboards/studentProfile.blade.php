@extends('frontend.web_layout.master')

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb-bar text-center" style="padding: 100px 0; margin-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title mb-2">My Profile</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('frontend.layout.index') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<div class="content">
    <div class="container">
        <!-- profile box -->
        @include('frontend.dashboards.profileBox')

        <!-- profile box -->
        <div class="row">
            <!-- sidebar -->

            @include('frontend.dashboards.sidebar')
            <!-- sidebar -->
            <div class="col-lg-9">
                <div class="card mb-2">
                    <div class="card-body">
                        <h6 class="fs-18 page-title fw-bold">Basic Information</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <h6>Name</h6>
                                    <span>{{ $user->name ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <h6>Registration Date</h6>
                                    <span>{{ $user->created_at ? $user->created_at->format('d M Y, h:i A') : 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <h6>Email</h6>
                                    <span>{{ $user->email ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card mb-0">
                    <div class="card-body">
                        <h6 class="fs-18 page-title fw-bold mb-4">Personal Information</h6>
                        <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="card p-4 mb-4">
                                <div class="row gy-4 align-items-center">

                                    <div class="col-xl-3"><label class="fw-medium">Profile Image :</label></div>
                                    <div class="col-xl-9">
                                        <input type="file" id="profile_image" name="profile_image" class="d-none">
                                        <label for="profile_image"
                                            id="profile_image_label"
                                            class="form-control rounded-3"
                                            style="height: 45px; display: flex; align-items: center; padding-left: 10px; cursor: pointer;">
                                            Choose a file
                                        </label>
                                    </div>

                                    <div class="col-xl-3"><label class="fw-medium">Name :</label></div>
                                    <div class="col-xl-9">
                                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                                    </div>

                                    <div class="col-xl-3"><label class="fw-medium">Email :</label></div>
                                    <div class="col-xl-9">
                                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                                    </div>

                                    <div class="col-xl-3"><label class="fw-medium">Phone Number :</label></div>
                                    <div class="col-xl-9">
                                        <input type="text" name="phone_number" class="form-control"
                                            value="{{ old('phone_number', $student->alternate_contact_number ?? '') }}">
                                    </div>

                                    <div class="col-xl-3"><label class="fw-medium">Gender :</label></div>
                                    <div class="col-xl-9">
                                        <select name="gender" class="form-control">
                                            <option value="">Select Gender</option>
                                            <option value="Male" {{ ($student->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ ($student->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                            <option value="Other" {{ ($student->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>

                                    <div class="col-xl-3"><label class="fw-medium">Date of Birth :</label></div>
                                    <div class="col-xl-9" style="position: relative; display: flex; align-items: center;">
                                        <input
                                            type="text"
                                            id="dob"
                                            name="dob"
                                            value="{{ old('dob', $student->dob ?? '') }}"
                                            placeholder="DD-MM-YYYY"
                                            style="flex: 1;
                background-color: #fff; 
                color: #000; 
                border-radius: 8px; 
                height: 45px;
                padding: 0 70px 0 12px; /* increased right padding */
                border: 1px solid #ccc;
                font-size: 14px;">
                                        <i class="isax isax-calendar"
                                            style="position: absolute; 
              right: 20px; /* move icon slightly left */
              top: 50%;
              transform: translateY(-50%);
              cursor: pointer;
              color: #555;"
                                            onclick="document.getElementById('dob')._flatpickr.open();">
                                        </i>
                                    </div>



                                    <div class="col-xl-3"><label class="fw-medium">Bio :</label></div>
                                    <div class="col-xl-9">
                                        <textarea name="bio" class="form-control" rows="3">{{ old('bio', $student->bio ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="btn btn-primary">Save Profile</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>

@endsection

@push('scripts')
<script>
    const fileInput = document.getElementById('profile_image');
    const fileLabel = document.getElementById('profile_image_label');

    fileInput.addEventListener('change', function() {
        if (fileInput.files.length > 0) {
            // Replace label text with file name
            fileLabel.textContent = fileInput.files[0].name;
        } else {
            fileLabel.textContent = 'Choose a file'; // fallback
        }
    });
</script>

<!-- Include Flatpickr JS & CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#dob", {
        dateFormat: "d-m-Y",
        allowInput: true,
        altInput: true,
        altFormat: "d-m-Y",
        wrap: false,
        onReady: function(selectedDates, dateStr, instance) {
            // you can also dynamically handle dark/light mode here
        }
    });
</script>
@endpush