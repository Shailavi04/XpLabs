@extends('frontend.web_layout.master')

@section('content')

<!-- Course detail -->
<section class="course-details-two" style="padding-top:125px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card bg-light">
                    <div class="card-body d-lg-flex align-items-center">

                        <div class="position-relative">
                            <a href="https://www.youtube.com/embed/1trvO6dqQUI" id="openVideoBtn" target="_blank">
                                <img class="img-fluid w-100 rounded-2" src="{{ asset('/uploads/courses/' . $course->image) }}" alt="img">

                                <div class="play-icon">
                                    <i class="ti ti-player-play-filled fs-28"></i>
                                    <img src="{{ asset('frontend/assets/img/icon/play-icon-filled.png') }}" alt="Play" style="width:110px; height: 60px;">
                                </div>
                            </a>
                        </div>

                        <div id="videoModal">
                            <div class="modal-content1">
                                <span class="close-btn" id="closeModal">&times;</span>
                                <iframe id="youtubeIframe" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="w-100 ps-lg-4">
                            <h3 class="mb-2" style="color:black !important;">{{ $course->name}}</h3>
                            <p class="fs-14 mb-3">{{ $course->description}}</p>
                            <div class="d-flex align-items-center gap-2 gap-sm-3 gap-xl-4 flex-wrap my-3 my-sm-0">
                                <p class="fw-medium d-flex align-items-center mb-0"><img class="me-2" src="{{ asset('frontend/assets/img/icons/book.svg') }}" alt="img">92 Lessons</p>
                                <p class="fw-medium d-flex align-items-center mb-0"><img class="me-2" src="{{ asset('frontend/assets/img/icons/timer-start.svg')}}" alt="img">{{ $course->duration }}</p>
                                <p class="fw-medium d-flex align-items-center mb-0"><img class="me-2" src="{{ asset('frontend/assets/img/icons/people.svg')}}" alt="img">85 students enrolled</p>
                                <span class="badge badge-sm rounded-pill bg-warning fs-12">{{ $course->category->name }}</span>
                            </div>
                            <div class="d-sm-flex align-items-center justify-content-sm-between mt-3">
                                <div class="d-flex align-items-center">

                                    <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                        <i class="fa-solid fa-star text-warning me-1"></i>
                                        <i class="fa-solid fa-star text-warning me-1"></i>
                                        <i class="fa-solid fa-star text-warning me-1"></i>
                                        <i class="fa-solid fa-star text-warning me-1"></i>
                                        <i class="fa-solid fa-star text-gray-1 me-1"></i>
                                        <p class=" fs-14"><span class="text-gray-100"> 4.4 rating</span>(15)</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-8">
                <div>
                    <img src="{{ asset('frontend/assets/img/course/course-details-two-2.jpg') }}" alt="img" class="img-fluid mb-4">
                </div>
                <div class="course-page-content pt-0">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-3">Overview</h5>
                            <h6 class="mb-2">Course Description</h6>
                            <p>Embark on a transformative journey into AI with Mike Wheeler, your guide in this Udemy Best Seller course on ChatGPT and Prompt Engineering. As an experience instructor who has taught well over 300,000 students, Mike unveils the secrets of developing your own custom GPTs, ensuring your skills shine in the thriving digital marketplace. </p>
                            <p>This course will get your familiar with Generative AI&nbsp;and the effective use of ChatGPT and is perfect for the beginner. You will also learn advanced prompting techniques to take your Prompt Engineering skills to the next level!</p>
                            <h6 class="mb-2">What you'll learn</h6>
                            <ul class="custom-list mb-3">
                                <li class="list-item">Become a UX designer</li>
                                <li class="list-item">You will be able to add UX designer to your CV</li>
                                <li class="list-item">Become a UI designer</li>
                                <li class="list-item">Build &amp; test a full website design.</li>
                                <li class="list-item">Build &amp; test a full mobile app.</li>
                            </ul>
                            <h6 class="mb-2">Requirements</h6>
                            <ul class="custom-list mb-0">
                                <li class="list-item">You will need a copy of Adobe XD 2019 or above. A free trial can be downloaded from Adobe.</li>
                                <li class="list-item">No previous design experience is needed.</li>
                                <li class="list-item">No previous Adobe XD skills are needed.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between flex-wrap">
                                <h5 class="subs-title mb-2 mb-sm-3">Course Content</h5>
                                <h6 class="fs-16 fw-medium text-gray-7 mb-3">92 Lectures <span class="text-secondary">{{ $course->duration }}</span></h6>
                            </div>

                            <div class="accordion" id="accordioncustomicon1Example">

                                <!-- Accordion Item 1 -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="color:black;">
                                            Getting Started
                                            <i class="fa-solid fa-chevron-down ms-auto"></i>
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordioncustomicon1Example">
                                        <div class="accordion-body p-0">
                                            <ul class="list-unstyled m-0">

                                                <!-- Repeatable Lecture Item -->
                                                <li class="p-3 d-flex justify-content-between align-items-center border-bottom">
                                                    <p class="mb-0 d-flex align-items-center">
                                                        <img src="{{ asset('frontend/assets/img/icons/play.svg') }}" class="me-2" alt="Play" />
                                                        Lecture1.1 Introduction to the User Experience Course
                                                    </p>
                                                    <div class="d-flex gap-3">
                                                        <a href="#" class="text-primary text-decoration-none">Preview</a>
                                                        <p>02:30</p>
                                                    </div>
                                                </li>

                                                <li class="p-3 d-flex justify-content-between align-items-center border-bottom">
                                                    <p class="mb-0 d-flex align-items-center">
                                                        <img src="{{asset('frontend/assets/img/icons/play.svg')}}" class="me-2" alt="Play" />
                                                        Lecture1.1 Introduction to the User Experience Course
                                                    </p>
                                                    <div class="d-flex gap-3">
                                                        <a href="#" class="text-primary text-decoration-none">Preview</a>
                                                        <p>02:30</p>
                                                    </div>
                                                </li>
                                                <li class="p-3 d-flex justify-content-between align-items-center border-bottom">
                                                    <p class="mb-0 d-flex align-items-center">
                                                        <img src="{{asset('frontend/assets/img/icons/play.svg')}}" class="me-2" alt="Play" />
                                                        Lecture1.1 Introduction to the User Experience Course
                                                    </p>
                                                    <div class="d-flex gap-3">
                                                        <a href="#" class="text-primary text-decoration-none">Preview</a>
                                                        <p>02:30</p>
                                                    </div>
                                                </li>
                                                <li class="p-3 d-flex justify-content-between align-items-center border-bottom">
                                                    <p class="mb-0 d-flex align-items-center">
                                                        <img src="{{asset('frontend/assets/img/icons/play.svg')}}" class="me-2" alt="Play" />
                                                        Lecture1.1 Introduction to the User Experience Course
                                                    </p>
                                                    <div class="d-flex gap-3">
                                                        <a href="#" class="text-primary text-decoration-none">Preview</a>
                                                        <p>02:30</p>
                                                    </div>
                                                </li>
                                                <li class="p-3 d-flex justify-content-between align-items-center border-bottom">
                                                    <p class="mb-0 d-flex align-items-center">
                                                        <img src="{{asset('frontend/assets/img/icons/play.svg')}}" class="me-2" alt="Play" />
                                                        Lecture1.1 Introduction to the User Experience Course
                                                    </p>
                                                    <div class="d-flex gap-3">
                                                        <a href="#" class="text-primary text-decoration-none">Preview</a>
                                                        <p>02:30</p>
                                                    </div>
                                                </li>
                                                <!-- Duplicate above for other lectures  -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Accordion Item 2  -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="color:black;">
                                            The Brief
                                            <i class="fa-solid fa-chevron-down ms-auto"></i>
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordioncustomicon1Example">
                                        <div class="accordion-body p-0">
                                            <ul class="list-unstyled m-0">

                                                <!-- Repeatable Lecture Item -->


                                                <li class="p-3 d-flex justify-content-between align-items-center border-bottom">
                                                    <p class="mb-0 d-flex align-items-center">
                                                        <img src="{{asset('frontend/assets/img/icons/play.svg')}}" class="me-2" alt="Play" />
                                                        Lecture 2
                                                    </p>
                                                    <div class="d-flex gap-3">
                                                        <a href="#" class="text-primary text-decoration-none">Preview</a>
                                                        <p>02:30</p>
                                                    </div>
                                                </li>
                                        </div>
                                    </div>
                                </div>

                                <!-- Accordion Item 3 -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" style="color:black;">
                                            Wireframing Low Fidelity
                                            <i class="fa-solid fa-chevron-down ms-auto"></i>
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordioncustomicon1Example">
                                        <div class="accordion-body p-0">
                                            <ul class="list-unstyled m-0">

                                                <!-- Repeatable Lecture Item -->

                                                <li class="p-3 d-flex justify-content-between align-items-center border-bottom">
                                                    <p class="mb-0 d-flex align-items-center">
                                                        <img src="{{asset('frontend/assets/img/icons/play.svg')}}" class="me-2" alt="Play" />
                                                        Lecture 3
                                                    </p>
                                                    <div class="d-flex gap-3">
                                                        <a href="#" class="text-primary text-decoration-none">Preview</a>
                                                        <p>02:30</p>
                                                    </div>
                                                </li>
                                        </div>
                                    </div>
                                </div>

                                <!-- Accordion Item 4 -->
                                <div class="accordion-item mb-0">
                                    <h2 class="accordion-header" id="headingFour">
                                        <button class="accordion-button collapsed d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" style="color:black;">
                                            Type, Color & Icon Introduction
                                            <i class="fa-solid fa-chevron-down ms-auto"></i>
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordioncustomicon1Example">
                                        <div class="accordion-body p-0">
                                            <ul class="list-unstyled m-0">

                                                <!-- Repeatable Lecture Item -->

                                                <li class="p-3 d-flex justify-content-between align-items-center border-bottom">
                                                    <p class="mb-0 d-flex align-items-center">
                                                        <img src="{{asset('frontend/assets/img/icons/play.svg')}}" class="me-2" alt="Play" />
                                                        Lecture 4
                                                    </p>
                                                    <div class="d-flex gap-3">
                                                        <a href="#" class="text-primary text-decoration-none">Preview</a>
                                                        <p>02:30</p>
                                                    </div>
                                                </li>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-4">Student Reviews</h5>

                        <!-- Review 1 -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ asset('frontend/uploads/testimonials/688f77ad8d708.jpg') }}" alt="Student" class="rounded-circle me-3" width="50" height="50">
                                <div>
                                    <h6 class="mb-0">Shivangi Pandey</h6>
                                    <small class="text-muted">Verified Learner </small>
                                </div>
                            </div>
                            <p class="mb-1">I love the courses</p>
                            <div class="text-warning fs-14">
                                ★★★★☆
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ asset('frontend/uploads/testimonials/688f77ad8d708.jpg') }}" alt="Student" class="rounded-circle me-3" width="50" height="50">
                                <div>
                                    <h6 class="mb-0">Mehandi Jaiswal</h6>
                                    <small class="text-muted">Verified Learner </small>
                                </div>
                            </div>
                            <p class="mb-1">I love the courses</p>
                            <div class="text-warning fs-14">
                                ★★★★☆
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="course-sidebar-sec mt-0">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h2 class="text-success fs-30">FREE</h2>
                                <p class="fs-14 mb-0"><span class="text-decoration-line-through me-2">{{ $course->price }}</span>{{ $course->off }}% off</p>
                            </div>
                            <div class="d-flex justify-content-between gap-3 wishlist-btns">
                                <a class="btn d-flex btn-wish" href="{{{ route('frontend.dashboards.studentWishlist') }}}"><i class="isax isax-heart me-1 fs-18"></i>Add to Wishlist</a>
                                <a class="btn d-flex btn-wish" href="#"><i class="ti ti-share me-1 fs-18"></i>Share</a>
                            </div>
                            <a href="#"
                                class="btn btn-primary w-100 mt-3 btn-enroll"
                                data-bs-toggle="modal"
                                data-bs-target="#enrollModal"
                                @if(!Auth::check()) onclick="window.location='{{ route('frontend.layout.login') }}'" @endif>
                                Enroll Now
                            </a>

                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="subs-title mb-4">Includes</h5>
                            <p class="mb-3"><img class="me-2" src="{{ asset('assets/img/icons/play.svg') }}" alt="img">11 hours on-demand video</p>
                            <p class="mb-3"><img class="me-2" src="{{ asset('assets/img/icons/import.svg') }}" alt="img">69 downloadable resources</p>
                            <p class="mb-3"><img class="me-2" src="{{ asset('assets/img/icons/key.svg') }}" alt="img">Full lifetime access</p>
                            <p class="mb-3"><img class="me-2" src="{{ asset('assets/img/icons/monitor-mobbile.svg ')}}" alt="img">Access on mobile and TV</p>
                            <p class="mb-3"><img class="me-2" src="{{ asset('assets/img/icons/cloud-lightning.svg') }}" alt="img">Assignments</p>
                            <p class="mb-0"><img class="me-2" src="{{ asset('assets/img/icons/teacher.svg') }}" alt="img">Certificate of Completion</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body cou-features">
                            <h5 class="subs-title">Course Features</h5>
                            <ul>
                                <li>
                                    <p class="mb-0"><img class="me-2" src="{{ asset('assets/img/icons/people2.svg') }}" alt="img">Enrolled: {{ $course->enrolled }} students</p>
                                </li>
                                <li>
                                    <p class="mb-0"><img class="me-2" src="{{ asset('assets/img/icons/timer-start3.svg') }}" alt="img">Duration: {{ $course->duration }}</p>
                                </li>
                                <li>
                                    <p class="mb-0"><img class="me-2" src="{{ asset('assets/img/icons/note.svg') }}" alt="img">Chapters: {{ $course->lessons }}</p>
                                </li>
                                <li>
                                    <p class="mb-0"><img class="me-2" src="{{ asset('assets/img/icons/play3.svg') }}" alt="img">Video: {{ $course->Video }}</p>
                                </li>
                                <li>
                                    <p class="mb-0"><img class="me-2" src="{{ asset('assets/img/icons/chart.svg') }}" alt="img">Level: {{ $course->Level }}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</section>
<!-- /Course detail -->


{{-- Enrollment Modal --}}
<div class="modal fade" id="enrollModal" tabindex="-1" aria-labelledby="enrollModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="enrollModalLabel">Student Enrollment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="addEnrollmentForm">
                    @csrf
                    <div class="row gy-4 align-items-center">

                        {{-- Student --}}
                        <div class="col-xl-3">
                            <label class="fw-medium">Student <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-xl-9">
                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                            <input type="hidden" name="student_id" value="{{ auth()->user()->id }}">
                        </div>

                        {{-- Course --}}
                        <div class="col-xl-3">
                            <label class="fw-medium">Course <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-xl-9">
                            @if($course)
                            <input type="text" class="form-control" value="{{ $course->name }} ({{ $course->duration }})" readonly>
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            @else
                            <p class="text-danger">No course selected.</p>
                            @endif
                        </div>

                        {{-- Center --}}
                        <div class="col-md-3">
                            <label class="fw-medium">Select Center <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <select name="center_id" class="form-select" required>
                                <option value="">-- Select Center --</option>
                                @foreach($centers as $center)
                                <option value="{{ $center->id }}">{{ $center->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Token Amount --}}
                        <div class="col-xl-3">
                            <label class="fw-medium">Token Amount :</label>
                        </div>
                        <div class="col-xl-9">
                            @if($course)
                            <input type="number" class="form-control" id="tokenAmount" name="token_amount" value="{{ $course->token_amount }}" readonly>
                            @endif
                        </div>

                        {{-- Total Fee --}}
                        <div class="col-xl-3">
                            <label class="fw-medium">Total Fee:</label>
                        </div>
                        <div class="col-xl-9">
                            @if($course)
                            <input type="number" class="form-control" name="total_fee" value="{{ $course->total_fee }}" readonly>
                            @endif
                        </div>

                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="payNowBtn">Pay Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const payBtn = document.getElementById('payNowBtn');
        if (!payBtn) return;

        payBtn.addEventListener('click', function(e) {
            e.preventDefault();
            payBtn.disabled = true;

            const courseId = "{{ $course->id }}";
            const centerId = "{{ $student ? $centers->first()->id ?? '' : '' }}";

            fetch("{{ route('payments.ajaxCreateOrder') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        course_id: courseId,
                        center_id: centerId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        payBtn.disabled = false;
                        return;
                    }

                    const options = {
                        key: data.key,
                        amount: data.amount,
                        currency: data.currency,
                        name: "XPLabs",
                        description: "Course Payment",
                        order_id: data.order_id,
                        handler: function(response) {
                            fetch("{{ route('payments.ajaxVerify') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify(response)
                                })
                                .then(res => res.json())
                                .then(result => {
                                    if (result.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Payment Successful!',
                                            text: result.message,
                                            showCancelButton: true,
                                            confirmButtonText: 'Go to My Courses',
                                            cancelButtonText: 'Download Receipt',
                                        }).then((res) => {
                                            if (res.isConfirmed) {
                                                window.location.href = "{{ route('frontend.dashboards.studentCourses') }}";
                                            } else if (res.dismiss === Swal.DismissReason.cancel) {
                                                window.open(result.receipt_url, '_blank');
                                            }
                                        });

                                    } else {
                                        alert(result.error || 'Payment verification failed');
                                        payBtn.disabled = false;
                                    }
                                })
                                .catch(err => {
                                    console.error(err);
                                    alert("Verification failed");
                                    payBtn.disabled = false;
                                });
                        },
                        modal: {
                            ondismiss: () => payBtn.disabled = false
                        },
                        theme: {
                            color: "#3399cc"
                        }
                    };
                    new Razorpay(options).open();
                })
                .catch(err => {
                    console.error(err);
                    alert("Order creation failed");
                    payBtn.disabled = false;
                });
        });
    });
</script>
@endpush