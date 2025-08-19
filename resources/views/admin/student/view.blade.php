@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row align-items-stretch">
            <!-- LEFT SIDE -->
            <div class="col-md-4 col-lg-3">
                <div class="card shadow-sm rounded-4 p-4" style="height:461px",>
                    <div class="text-center mb-4 position-relative" style="width: 80px; margin: 0 auto;">
                        @if ($student->image)
                            <img id="profileImage" src="{{ asset('uploads/students/' . $student->image) }}"
                                class="rounded-circle mb-2"
                                style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;" alt="Student Image">
                        @else
                            <div id="profileImage"
                                class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mb-2"
                                style="width: 80px; height: 80px; cursor: pointer;">
                                {{ strtoupper(substr($student->name, 0, 2)) }}
                            </div>
                        @endif

                        <!-- Overlay icon for edit -->
                        <label for="imageUpload"
                            style="position: absolute; bottom: 0; right: 0; background: #0d6efd; color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <i class="bi bi-plus"></i>
                        </label>
                    </div>

                    <h6 class="mb-0 fw-bold text-center">{{ $student->name }}</h6>
                    <small class="text-muted d-block text-center">{{ $student->email }}</small>

                    <ul class="nav flex-column nav-pills mb-4 mt-4">
                        <li class="nav-item mb-1">
                            <button class="nav-link active text-start" data-bs-toggle="pill" data-bs-target="#info">
                                <i class="bi bi-person-lines-fill me-2"></i> Profile
                            </button>
                        </li>
                        <li class="nav-item mb-1">
                            <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#courses">
                                <i class="bi bi-book me-2"></i> Enrollment
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#activity">
                                <i class="bi bi-activity me-2"></i> Payments Transaction
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="col-md-8 col-lg-9 h-100">
                <div class="tab-content" style="height:400px;"> <!-- Profile Tab -->
                    <div class="tab-pane fade show active" id="info">
                        <div class="card shadow-sm rounded-4 h-100 p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0">Student Profile</h5>
                                <button class="btn btn-sm btn-outline-secondary" id="editProfileBtn">
                                    <i class="bi bi-pencil me-1"></i> Edit Profile
                                </button>
                            </div>

                            <!-- Display Profile -->
                            <div id="profileView">
                                @php
                                    $profileFields = [
                                        'Full Name' => $student->name,
                                        'Email' => $student->email,
                                        'Mobile' => $student->mobile ?? '-',
                                        'Gender' => ucfirst($student->gender) ?? '-',
                                        'Date of Birth' => $student->dob
                                            ? \Carbon\Carbon::parse($student->dob)->format('d M, Y')
                                            : '-',
                                        'City' => $student->city ?? '-',
                                        'Education Level' => $student->education_level ?? '-',
                                        'Bio' => nl2br(e($student->bio)) ?? '-',
                                        'Status' => $student->status ? 'Active' : 'Inactive',
                                        'Created At' => $student->created_at
                                            ? $student->created_at->format('d M Y')
                                            : '-',
                                    ];
                                @endphp

                                @foreach ($profileFields as $label => $value)
                                    <div class="row mb-3">
                                        <div class="col-sm-4 text-muted">{{ $label }}</div>
                                        <div class="col-sm-8 fw-medium">
                                            @if ($label == 'Status')
                                                <span
                                                    class="badge bg-{{ $student->status ? 'success' : 'secondary' }}">{{ $value }}</span>
                                            @else
                                                {!! $value !!}
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Edit Profile Form -->
                            <form method="POST" action="{{ route('student.profile_update', $student->id) }}"
                                enctype="multipart/form-data" id="profileForm" class="d-none">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-sm-4 text-muted">Full Name</div>
                                    <div class="col-sm-8">
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $student->name }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4 text-muted">Email</div>
                                    <div class="col-sm-8">
                                        <input type="email" name="email" class="form-control"
                                            value="{{ $student->email }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4 text-muted">Mobile</div>
                                    <div class="col-sm-8">
                                        <input type="text" name="mobile" class="form-control"
                                            value="{{ $student->mobile }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4 text-muted">Gender</div>
                                    <div class="col-sm-8">
                                        <select name="gender" class="form-select">
                                            <option value="male" {{ $student->gender == 'male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female" {{ $student->gender == 'female' ? 'selected' : '' }}>
                                                Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4 text-muted">Date of Birth</div>
                                    <div class="col-sm-8">
                                        <input type="date" name="dob" class="form-control"
                                            value="{{ $student->dob }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4 text-muted">City</div>
                                    <div class="col-sm-8">
                                        <input type="text" name="city" class="form-control"
                                            value="{{ $student->city }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4 text-muted">Education Level</div>
                                    <div class="col-sm-8">
                                        <input type="text" name="education_level" class="form-control"
                                            value="{{ $student->education_level }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4 text-muted">Bio</div>
                                    <div class="col-sm-8">
                                        <textarea name="bio" class="form-control" rows="3">{{ $student->bio }}</textarea>
                                    </div>
                                </div>

                                <!-- Image Upload with preview -->
                                <div class="row mb-3">
                                    <div class="col-sm-4 text-muted">Change Image</div>
                                    <div class="col-sm-8">
                                        <input type="file" name="image" id="imageUpload" class="form-control"
                                            accept="image/*" style="display:none;">
                                        <img id="imagePreview"
                                            src="{{ $student->image ? asset('uploads/students/' . $student->image) : '' }}"
                                            alt=""
                                            style="max-width: 120px; max-height: 120px; display: {{ $student->image ? 'block' : 'none' }}; margin-top: 10px; cursor: pointer;">
                                        <small class="text-muted">Click the plus icon or image to change</small>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-1"></i> Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>



                    <!-- Enrollments and Transactions tabs unchanged... -->
                    <!-- Enrollments Tab -->
                    <div class="tab-pane fade" id="courses">
                        <div class="card shadow-sm rounded-4 h-100 p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0">Enroll in Course</h5>
                            </div>

                            {{-- Include the enrollment form --}}
                            @include('admin.student.enrollment_form', ['student' => $student])
                        </div>
                    </div>

                    {{-- Suppose aapke paas $subscription variable hai controller se pass hua --}}

                    <div class="tab-pane fade" id="activity">
                        @if ($student->enrollments->count() > 0)
                            @include('admin.student.payment', ['enrollments' => $student->enrollments])
                        @else
                            <p>No enrollments found to show payments.</p>
                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            document.getElementById('editProfileBtn').addEventListener('click', function() {
                document.getElementById('profileForm').classList.remove('d-none');
                document.getElementById('profileView').classList.add('d-none');
                this.classList.add('d-none');
            });

            // Clicking on image preview opens file input
            document.getElementById('imagePreview').addEventListener('click', function() {
                document.getElementById('imageUpload').click();
            });

            // Preview uploaded image immediately
            document.getElementById('imageUpload').addEventListener('change', function() {
                const [file] = this.files;
                if (file) {
                    const preview = document.getElementById('imagePreview');
                    preview.src = URL.createObjectURL(file);
                    preview.style.display = 'block';
                }
            });
        </script>
    @endpush
@endsection
