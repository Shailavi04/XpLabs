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
                            <img src="{{ $user->profile_image ? asset('uploads/user/' . $user->profile_image) : asset('admin/assets/images/faces/4.jpg') }}"
                                alt="Avatar">

                        </span>
                        <div class="mt-4 mb-3 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                            <div>
                                <h5 class="fw-semibold mb-1">{{ $user->name }}</h5>
                                <span class="d-block fw-medium text-muted mb-1">{{ $user->role->name ?? 'No Role' }}</span>
                                <p class="fs-12 mb-0 fw-medium text-muted">
                                    <span class="me-3"><i
                                            class="ri-building-line me-1 align-middle"></i>{{ $user->address ?? 'Location not set' }}</span>
                                    <span><i class="ri-map-pin-line me-1 align-middle"></i>{{ $user->city ?? '' }}</span>
                                </p>
                            </div>
                            {{-- <div class="d-flex mb-0 flex-wrap gap-5">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="main-card-icon primary">
                                        <div
                                            class="avatar avatar-lg bg-primary avatar-rounded border border-primary border-opacity-10">
                                            <i class="ri-briefcase-line fs-18"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="mb-0 fs-12 text-muted fw-medium">Classes</p>
                                        <p class="fw-semibold fs-20 mb-0">{{ $user->projects_count ?? 0 }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="main-card-icon secondary">
                                        <div
                                            class="avatar avatar-lg bg-secondary avatar-rounded border border-secondary border-opacity-10">
                                            <i class="ri-group-line fs-18"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="mb-0 fs-12 text-muted fw-medium">Student</p>
                                        <p class="fw-semibold fs-20 mb-0">{{ $user->followers_count ?? '0' }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="main-card-icon success">
                                        <div
                                            class="avatar avatar-lg bg-success avatar-rounded border border-success border-opacity-10">
                                            <i class="ri-user-follow-line fs-18"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="mb-0 fs-12 text-muted fw-medium">Instructor</p>
                                        <p class="fw-semibold fs-20 mb-0">{{ $user->following_count ?? '0' }}</p>
                                    </div>
                                </div>
                            </div> --}}
                        </div>

                        <ul class="nav nav-tabs mb-0 tab-style-8 scaleX" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="profile-about-tab" data-bs-toggle="tab"
                                    data-bs-target="#profile-about-tab-pane" type="button" role="tab"
                                    aria-controls="profile-about-tab-pane" aria-selected="true">Profile</button>
                            </li>

                            {{-- <li class="nav-item" role="presentation">
                                <button class="nav-link" id="timeline-tab" data-bs-toggle="tab"
                                    data-bs-target="#timeline-tab-pane" type="button" role="tab"
                                    aria-controls="timeline-tab-pane" aria-selected="false">Timeline</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="gallery-tab" data-bs-toggle="tab"
                                    data-bs-target="#gallery-tab-pane" type="button" role="tab"
                                    aria-controls="gallery-tab-pane" aria-selected="false">Gallery</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="friends-tab" data-bs-toggle="tab"
                                    data-bs-target="#friends-tab-pane" type="button" role="tab"
                                    aria-controls="friends-tab-pane" aria-selected="false">Friends</button>
                            </li> --}}
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
                                        <span class="fw-medium text-default">Address: </span>
                                        {{ optional($user->centers->first())->address ?? 'N/A' }}
                                    </p>
                                    <p class="mb-0">
                                        <span class="avatar avatar-sm avatar-rounded text-warning">
                                            <i class="ri-map-pin-line align-middle fs-15"></i>
                                        </span>
                                        <span class="fw-medium text-default">Location: </span>
                                        {{ optional($user->centers->first())->city ?? 'N/A' }},
                                        {{ optional($user->centers->first())->state ?? 'N/A' }},
                                        {{ optional($user->centers->first())->postal_code ?? '' }}

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


                                        <div class="card-body">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>

                                    </ul>


                                </form>



                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-0 border-0" id="edit-profile-tab-pane" role="tabpanel"
                        aria-labelledby="edit-profile-tab" tabindex="0">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">

                                    <li class="list-group-item p-4">
                                        <span class="fw-medium fs-15 d-block mb-3">Contact Info :</span>
                                        <div class="row gy-4 align-items-center">
                                            <div class="col-xl-3">
                                                <div class="lh-1">
                                                    <span class="fw-medium">Email :</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-9">
                                                <input type="email" class="form-control" placeholder="Placeholder"
                                                    value="your.email@example.com">
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="lh-1">
                                                    <span class="fw-medium">Phone :</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-9">
                                                <input type="text" class="form-control" placeholder="Placeholder"
                                                    value="+1 (555) 123-4567">
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="lh-1">
                                                    <span class="fw-medium">Website :</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-9">
                                                <input type="text" class="form-control" placeholder="Placeholder"
                                                    value="www.yourwebsite.com">
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="lh-1">
                                                    <span class="fw-medium">Location :</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-9">
                                                <input type="text" class="form-control" placeholder="Placeholder"
                                                    value="City, Country">
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item p-4">
                                        <span class="fw-medium fs-15 d-block mb-3">Social Info :</span>
                                        <div class="row gy-4 align-items-center">
                                            <div class="col-xl-3">
                                                <div class="lh-1">
                                                    <span class="fw-medium">Github :</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-9">
                                                <input type="text" class="form-control" placeholder="Placeholder"
                                                    value="github.com/spruko">
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="lh-1">
                                                    <span class="fw-medium">Twitter :</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-9">
                                                <input type="text" class="form-control" placeholder="Placeholder"
                                                    value="twitter.com/spruko.me">
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="lh-1">
                                                    <span class="fw-medium">Linkedin :</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-9">
                                                <input type="text" class="form-control" placeholder="Placeholder"
                                                    value="linkedin.com/in/spruko">
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="lh-1">
                                                    <span class="fw-medium">Portfolio :</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-9">
                                                <input type="text" class="form-control" placeholder="Placeholder"
                                                    value="spruko.com/">
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item p-4">
                                        <span class="fw-medium fs-15 d-block mb-3">About :</span>
                                        <div class="row gy-4 align-items-center">
                                            <div class="col-xl-3">
                                                <div class="lh-1">
                                                    <span class="fw-medium">Biographical Info :</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-9">
                                                <textarea class="form-control" id="text-area" rows="4">Hey there! I'm [Your Name], a passionate [Your Profession/Interest] based in [Your Location]. With a love for [Your Hobbies/Interests], I find joy in exploring the beauty of [Your Industry/Field]. Whether it's [Specific Skills or Expertise], I'm always eager to learn and grow.

                                                        I specialize in [Your Specialization/Area of Expertise], bringing creativity and innovation to every project. From [Key Achievements] to [Notable Experiences], my journey has been a thrilling ride, and I'm excited to share it with you.
                                                        </textarea>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item p-4 pb-5">
                                        <span class="fw-medium fs-15 d-block mb-3">Skills :</span>
                                        <div class="row gy-4 align-items-center">
                                            <div class="col-xl-3">
                                                <div class="lh-1">
                                                    <span class="fw-medium">skills :</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-9">
                                                <input class="form-control" id="choices-text-preset-values"
                                                    type="text"
                                                    value="Project Management,Data Analysis,Marketing Strategy,Graphic Design,Content Creation,Market Research,Client Relations,Event Planning,Budgeting and Finance,Negotiation Skills,Team Collaboration,Adaptability"
                                                    placeholder="This is a placeholder">
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-0 border-0" id="timeline-tab-pane" role="tabpanel"
                        aria-labelledby="timeline-tab" tabindex="0">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body p-4">
                                <ul class="list-unstyled profile-timeline">
                                    <li>
                                        <div>
                                            <span
                                                class="avatar avatar-sm bg-primary-transparent avatar-rounded profile-timeline-avatar">
                                                E
                                            </span>
                                            <p class="mb-2">
                                                <span class="fw-semibold">Started a new adventure!</span> &#127757; Excited
                                                to explore new opportunities and make memories..<span
                                                    class="float-end fs-11 text-muted">24,Dec 2024 - 14:34</span>
                                            </p>
                                            <p class="profile-activity-media mb-0">
                                                <a href="javascript:void(0);">
                                                    <img src="../assets/images/media/media-17.jpg" alt="">
                                                </a>
                                                <a href="javascript:void(0);">
                                                    <img src="../assets/images/media/media-18.jpg" alt="">
                                                </a>
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            <span class="avatar avatar-sm avatar-rounded profile-timeline-avatar">
                                                <img src="../assets/images/faces/11.jpg" alt="">
                                            </span>
                                            <p class="mb-2">
                                                Achieved a personal milestone today! &#127942; <span
                                                    class="text-primary fw-medium text-decoration-underline">#Hard work
                                                    pays off</span>.<span class="float-end fs-11 text-muted">18,Dec 2024 -
                                                    12:16</span>
                                            </p>
                                            <p class="text-muted mb-0">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae,
                                                repellendus rem rerum excepturi aperiam ipsam temporibus inventore ullam
                                                tempora eligendi libero sequi dignissimos cumque, et a sint tenetur
                                                consequatur omnis!
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            <span class="avatar avatar-sm avatar-rounded profile-timeline-avatar">
                                                <img src="../assets/images/faces/4.jpg" alt="">
                                            </span>
                                            <p class="text-muted mb-2">
                                                <span class="text-default">Attended an inspiring webinar on [topic].
                                                    Learning never stops! &#128218;</span>.<span
                                                    class="float-end fs-11 text-muted">21,Dec 2024 - 15:32</span>
                                            </p>
                                            <p class="profile-activity-media mb-0">
                                                <a href="javascript:void(0);">
                                                    <img src="../assets/images/media/file-manager/3.png" alt="">
                                                </a>
                                                <span class="fs-11 text-muted">432.87KB</span>
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            <span
                                                class="avatar avatar-sm bg-success-transparent avatar-rounded profile-timeline-avatar">
                                                P
                                            </span>
                                            <p class="text-muted mb-2">
                                                <span class="text-default">Shared a delicious recipe I tried out. Cooking
                                                    experiments are always fun! &#127858;</span>.<span
                                                    class="float-end fs-11 text-muted">28,Dec 2024 - 18:46</span>
                                            </p>
                                            <p class="profile-activity-media mb-2">
                                                <a href="javascript:void(0);">
                                                    <img src="../assets/images/media/media-75.jpg" alt="">
                                                </a>
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            <span class="avatar avatar-sm avatar-rounded profile-timeline-avatar">
                                                <img src="../assets/images/faces/5.jpg" alt="">
                                            </span>
                                            <p class="text-muted mb-1">
                                                <span class="text-default">Enjoyed a weekend getaway to <span
                                                        class="fw-semibold text-secondary text-decoration-underline">#Africa</span>.
                                                    Nature therapy at its best!</span>.<span
                                                    class="float-end fs-11 text-muted">11,Dec 2024 - 11:18</span>
                                            </p>
                                            <p class="text-muted">you are already feeling the tense atmosphere of the video
                                                playing in the background</p>
                                            <p class="profile-activity-media mb-0">
                                                <a href="javascript:void(0);">
                                                    <img src="../assets/images/media/media-59.jpg" class="m-1"
                                                        alt="">
                                                </a>
                                                <a href="javascript:void(0);">
                                                    <img src="../assets/images/media/media-60.jpg" class="m-1"
                                                        alt="">
                                                </a>
                                                <a href="javascript:void(0);">
                                                    <img src="../assets/images/media/media-61.jpg" class="m-1"
                                                        alt="">
                                                </a>
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            <span class="avatar avatar-sm avatar-rounded profile-timeline-avatar">
                                                <img src="../assets/images/media/media-39.jpg" alt="">
                                            </span>
                                            <p class="mb-1">
                                                Celebrated a friend's birthday with a surprise party! &#127881;<span
                                                    class="float-end fs-11 text-muted">24,Dec 2024 - 14:34</span>
                                            </p>
                                            <p class="profile-activity-media mb-0">
                                                <a href="javascript:void(0);">
                                                    <img src="../assets/images/media/media-26.jpg" alt="">
                                                </a>
                                                <a href="javascript:void(0);">
                                                    <img src="../assets/images/media/media-29.jpg" alt="">
                                                </a>
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-0 border-0" id="gallery-tab-pane" role="tabpanel"
                        aria-labelledby="gallery-tab" tabindex="0">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                        <a href="../assets/images/media/media-40.jpg" class="glightbox card"
                                            data-gallery="gallery1">
                                            <img src="../assets/images/media/media-40.jpg" alt="image">
                                        </a>
                                    </div>
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                        <a href="../assets/images/media/media-41.jpg" class="glightbox card"
                                            data-gallery="gallery1">
                                            <img src="../assets/images/media/media-41.jpg" alt="image">
                                        </a>
                                    </div>
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                        <a href="../assets/images/media/media-42.jpg" class="glightbox card"
                                            data-gallery="gallery1">
                                            <img src="../assets/images/media/media-42.jpg" alt="image">
                                        </a>
                                    </div>
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                        <a href="../assets/images/media/media-43.jpg" class="glightbox card"
                                            data-gallery="gallery1">
                                            <img src="../assets/images/media/media-43.jpg" alt="image">
                                        </a>
                                    </div>
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                        <a href="../assets/images/media/media-44.jpg" class="glightbox card"
                                            data-gallery="gallery1">
                                            <img src="../assets/images/media/media-44.jpg" alt="image">
                                        </a>
                                    </div>
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                        <a href="../assets/images/media/media-45.jpg" class="glightbox card"
                                            data-gallery="gallery1">
                                            <img src="../assets/images/media/media-45.jpg" alt="image">
                                        </a>
                                    </div>
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                        <a href="../assets/images/media/media-46.jpg" class="glightbox card"
                                            data-gallery="gallery1">
                                            <img src="../assets/images/media/media-46.jpg" alt="image">
                                        </a>
                                    </div>
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                        <a href="../assets/images/media/media-60.jpg" class="glightbox card"
                                            data-gallery="gallery1">
                                            <img src="../assets/images/media/media-60.jpg" alt="image">
                                        </a>
                                    </div>
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                        <a href="../assets/images/media/media-26.jpg" class="glightbox card"
                                            data-gallery="gallery1">
                                            <img src="../assets/images/media/media-26.jpg" alt="image">
                                        </a>
                                    </div>
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                        <a href="../assets/images/media/media-32.jpg" class="glightbox card"
                                            data-gallery="gallery1">
                                            <img src="../assets/images/media/media-32.jpg" alt="image">
                                        </a>
                                    </div>
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                        <a href="../assets/images/media/media-30.jpg" class="glightbox card"
                                            data-gallery="gallery1">
                                            <img src="../assets/images/media/media-30.jpg" alt="image">
                                        </a>
                                    </div>
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                        <a href="../assets/images/media/media-31.jpg" class="glightbox card"
                                            data-gallery="gallery1">
                                            <img src="../assets/images/media/media-31.jpg" alt="image">
                                        </a>
                                    </div>
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                        <a href="../assets/images/media/media-46.jpg" class="glightbox card"
                                            data-gallery="gallery1">
                                            <img src="../assets/images/media/media-46.jpg" alt="image">
                                        </a>
                                    </div>
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                        <a href="../assets/images/media/media-59.jpg" class="glightbox card"
                                            data-gallery="gallery1">
                                            <img src="../assets/images/media/media-59.jpg" alt="image">
                                        </a>
                                    </div>
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                        <a href="../assets/images/media/media-61.jpg" class="glightbox card"
                                            data-gallery="gallery1">
                                            <img src="../assets/images/media/media-61.jpg" alt="image">
                                        </a>
                                    </div>
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                        <a href="../assets/images/media/media-42.jpg" class="glightbox card"
                                            data-gallery="gallery1">
                                            <img src="../assets/images/media/media-42.jpg" alt="image">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-0 border-0" id="friends-tab-pane" role="tabpanel"
                        aria-labelledby="friends-tab" tabindex="0">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <div class="card custom-card shadow-none border">
                                            <div class="card-body p-4">
                                                <div class="text-center">
                                                    <span class="avatar avatar-xl avatar-rounded">
                                                        <img src="../assets/images/faces/2.jpg" alt="">
                                                    </span>
                                                    <div class="mt-2">
                                                        <p class="mb-0 fw-semibold">Samantha May</p>
                                                        <p class="fs-12 mb-1 text-muted">samanthamay2912@gmail.com</p>
                                                        <span class="badge bg-info-transparent">Team Member</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-center">
                                                <div class="d-flex gap-2 flex-wrap justify-content-center">
                                                    <div class="btn-list">
                                                        <button class="btn btn-sm btn-pink-light btn-wave">Block</button>
                                                        <button
                                                            class="btn btn-sm btn-primary btn-wave me-0">Unfollow</button>
                                                    </div>
                                                    <div class="dropdown">
                                                        <a aria-label="anchor"
                                                            class="btn btn-secondary btn-icon btn-sm btn-wave"
                                                            href="javascript:void(0);" data-bs-toggle="dropdown">
                                                            <i class="ri-more-2-fill"></i>
                                                        </a>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">Message</a></li>
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">Edit</a>
                                                            </li>
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">View</a>
                                                            </li>
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <div class="card custom-card shadow-none border">
                                            <div class="card-body p-4">
                                                <div class="text-center">
                                                    <span class="avatar avatar-xl avatar-rounded">
                                                        <img src="../assets/images/faces/15.jpg" alt="">
                                                    </span>
                                                    <div class="mt-2">
                                                        <p class="mb-0 fw-semibold">Andrew Garfield</p>
                                                        <p class="fs-12 mb-1 text-muted">andrewgarfield98@gmail.com</p>
                                                        <span class="badge bg-success-transparent">Team Lead</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-center">
                                                <div class="d-flex gap-2 flex-wrap justify-content-center">
                                                    <div class="btn-list">
                                                        <button class="btn btn-sm btn-pink-light btn-wave">Block</button>
                                                        <button
                                                            class="btn btn-sm btn-primary btn-wave me-0">Unfollow</button>
                                                    </div>
                                                    <div class="dropdown">
                                                        <a aria-label="anchor"
                                                            class="btn btn-secondary btn-icon btn-sm btn-wave"
                                                            href="javascript:void(0);" data-bs-toggle="dropdown">
                                                            <i class="ri-more-2-fill"></i>
                                                        </a>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">Message</a></li>
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">Edit</a>
                                                            </li>
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">View</a>
                                                            </li>
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <div class="card custom-card shadow-none border">
                                            <div class="card-body p-4">
                                                <div class="text-center">
                                                    <span class="avatar avatar-xl avatar-rounded">
                                                        <img src="../assets/images/faces/5.jpg" alt="">
                                                    </span>
                                                    <div class="mt-2">
                                                        <p class="mb-0 fw-semibold">Jessica Cashew</p>
                                                        <p class="fs-12 mb-1 text-muted">jessicacashew143@gmail.com</p>
                                                        <span class="badge bg-info-transparent">Team Member</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-center">
                                                <div class="d-flex gap-2 flex-wrap justify-content-center">
                                                    <div class="btn-list">
                                                        <button class="btn btn-sm btn-pink-light btn-wave">Block</button>
                                                        <button
                                                            class="btn btn-sm btn-primary btn-wave me-0">Unfollow</button>
                                                    </div>
                                                    <div class="dropdown">
                                                        <a aria-label="anchor"
                                                            class="btn btn-secondary btn-icon btn-sm btn-wave"
                                                            href="javascript:void(0);" data-bs-toggle="dropdown">
                                                            <i class="ri-more-2-fill"></i>
                                                        </a>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">Message</a></li>
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">Edit</a>
                                                            </li>
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">View</a>
                                                            </li>
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <div class="card custom-card shadow-none border">
                                            <div class="card-body p-4">
                                                <div class="text-center">
                                                    <span class="avatar avatar-xl avatar-rounded">
                                                        <img src="../assets/images/faces/11.jpg" alt="">
                                                    </span>
                                                    <div class="mt-2">
                                                        <p class="mb-0 fw-semibold">Simon Cowan</p>
                                                        <p class="fs-12 mb-1 text-muted">simoncowan12@gmail.com</p>
                                                        <span class="badge bg-warning-transparent">Team Manager</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-center">
                                                <div class="d-flex gap-2 flex-wrap justify-content-center">
                                                    <div class="btn-list">
                                                        <button class="btn btn-sm btn-pink-light btn-wave">Block</button>
                                                        <button
                                                            class="btn btn-sm btn-primary btn-wave me-0">Unfollow</button>
                                                    </div>
                                                    <div class="dropdown">
                                                        <a aria-label="anchor"
                                                            class="btn btn-secondary btn-icon btn-sm btn-wave"
                                                            href="javascript:void(0);" data-bs-toggle="dropdown">
                                                            <i class="ri-more-2-fill"></i>
                                                        </a>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">Message</a></li>
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">Edit</a>
                                                            </li>
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">View</a>
                                                            </li>
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <div class="card custom-card shadow-none border">
                                            <div class="card-body p-4">
                                                <div class="text-center">
                                                    <span class="avatar avatar-xl avatar-rounded">
                                                        <img src="../assets/images/faces/7.jpg" alt="">
                                                    </span>
                                                    <div class="mt-2">
                                                        <p class="mb-0 fw-semibold">Amanda nunes</p>
                                                        <p class="fs-12 mb-1 text-muted">amandanunes45@gmail.com</p>
                                                        <span class="badge bg-info-transparent">Team Member</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-center">
                                                <div class="d-flex gap-2 flex-wrap justify-content-center">
                                                    <div class="btn-list">
                                                        <button class="btn btn-sm btn-pink-light btn-wave">Block</button>
                                                        <button
                                                            class="btn btn-sm btn-primary btn-wave me-0">Unfollow</button>
                                                    </div>
                                                    <div class="dropdown">
                                                        <a aria-label="anchor"
                                                            class="btn btn-secondary btn-icon btn-sm btn-wave"
                                                            href="javascript:void(0);" data-bs-toggle="dropdown">
                                                            <i class="ri-more-2-fill"></i>
                                                        </a>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">Message</a></li>
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">Edit</a>
                                                            </li>
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">View</a>
                                                            </li>
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <div class="card custom-card shadow-none border">
                                            <div class="card-body p-4">
                                                <div class="text-center">
                                                    <span class="avatar avatar-xl avatar-rounded">
                                                        <img src="../assets/images/faces/12.jpg" alt="">
                                                    </span>
                                                    <div class="mt-2">
                                                        <p class="mb-0 fw-semibold">Mahira Hose</p>
                                                        <p class="fs-12 mb-1 text-muted">mahirahose9456@gmail.com</p>
                                                        <span class="badge bg-info-transparent">Team Member</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-center">
                                                <div class="d-flex gap-2 flex-wrap justify-content-center">
                                                    <div class="btn-list">
                                                        <button class="btn btn-sm btn-pink-light btn-wave">Block</button>
                                                        <button
                                                            class="btn btn-sm btn-primary btn-wave me-0">Unfollow</button>
                                                    </div>
                                                    <div class="dropdown">
                                                        <a aria-label="anchor"
                                                            class="btn btn-secondary btn-icon btn-sm btn-wave"
                                                            href="javascript:void(0);" data-bs-toggle="dropdown">
                                                            <i class="ri-more-2-fill"></i>
                                                        </a>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">Message</a></li>
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">Edit</a>
                                                            </li>
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">View</a>
                                                            </li>
                                                            <li><a class="dropdown-item"
                                                                    href="javascript:void(0);">Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="text-center">
                                            <button class="btn btn-primary-light btn-wave">Show All</button>
                                        </div>
                                    </div>
                                </div>
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
            let roleId = {{ $user->role_id ?? 'null' }};
            let role2Fields = document.getElementById("role2-fields");

            if (roleId == 2) {
                role2Fields.style.display = "block";
            } else {
                role2Fields.style.display = "none";
            }
        });
    </script>
@endpush
