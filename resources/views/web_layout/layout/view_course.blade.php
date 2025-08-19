@push('scripts')
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
@endpush


@extends('web_layout.master')

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
                                <img class="img-fluid rounded-2" src="{{ asset($course->image) }}" alt="img">
                                <div class="play-icon" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 5;">
                                    <img src="{{ asset('assets/img/icon/play.svg') }}" alt="Play" style="width:110px; height: 30px;">
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
                            <h3 class="mb-2" style="color:black !important;">{{ $course->title}}</h3>
                            <p class="fs-14 mb-3">{{ $course->description}}</p>
                            <div class="d-flex align-items-center gap-2 gap-sm-3 gap-xl-4 flex-wrap my-3 my-sm-0">
                                <p class="fw-medium d-flex align-items-center mb-0"><img class="me-2" src="{{ asset('assets/img/icons/book.svg') }}" alt="img">{{ $course->lessons }} Lessons</p>
                                <p class="fw-medium d-flex align-items-center mb-0"><img class="me-2" src="{{ asset('assets/img/icons/timer-start.svg')}}" alt="img">{{ $course->duration }}</p>
                                <p class="fw-medium d-flex align-items-center mb-0"><img class="me-2" src="{{ asset('assets/img/icons/people.svg')}}" alt="img">{{ $course->enrolled }} students enrolled</p>
                                <span class="badge badge-sm rounded-pill bg-warning fs-12">{{ $course->category }}</span>
                            </div>
                            <div class="d-sm-flex align-items-center justify-content-sm-between mt-3">
                                <div class="d-flex align-items-center">

                                    <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                        <i class="fa-solid fa-star text-warning me-1"></i>
                                        <i class="fa-solid fa-star text-warning me-1"></i>
                                        <i class="fa-solid fa-star text-warning me-1"></i>
                                        <i class="fa-solid fa-star text-warning me-1"></i>
                                        <i class="fa-solid fa-star text-gray-1 me-1"></i>
                                        <p class=" fs-14"><span class="text-gray-9">{{ $course->rating }}</span>({{ $course->ratedStudents }})</p>
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
                    <img src="{{ asset('assets/img/course/course-details-two-2.jpg') }}" alt="img" class="img-fluid mb-4">
                </div>
                <div class="course-page-content pt-0">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-3">Overview</h5>
                            <h6 class="mb-2">Course Description</h6>
                            <p>{{ $course->overview['courseDescription'] }}</p>
                            <h6 class="mb-2">What you'll learn</h6>
                            <ul class="custom-list mb-3">
                                <li class="list-item">{{ $course->overview['whatYouWillLearn'][0] }}</li>
                                <li class="list-item">{{ $course->overview['whatYouWillLearn'][1] }}</li>
                                <li class="list-item">{{ $course->overview['whatYouWillLearn'][2] }}</li>
                                <li class="list-item">{{ $course->overview['whatYouWillLearn'][3] }}</li>
                                <li class="list-item">{{ $course->overview['whatYouWillLearn'][4] }}</li>
                            </ul>
                            <h6 class="mb-2">Requirements</h6>
                            <ul class="custom-list mb-0">
                                <li class="list-item">{{ $course->overview['requirements'][0] }}</li>
                                <li class="list-item">{{ $course->overview['requirements'][1] }}</li>
                                <li class="list-item">{{ $course->overview['requirements'][2] }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between flex-wrap">
                                <h5 class="subs-title mb-2 mb-sm-3">Course Content</h5>
                                <h6 class="fs-16 fw-medium text-gray-7 mb-3">{{ $course->content['totalLectures'] }} Lectures <span class="text-secondary">{{ $course->content['totalDuration'] }}</span></h6>
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
                                                @foreach($course->content['sections'] as $section)
                                                <!-- Repeatable Lecture Item -->
                                                @foreach($section['lectures'] as $lecture)

                                                <li class="p-3 d-flex justify-content-between align-items-center border-bottom">
                                                    <p class="mb-0 d-flex align-items-center">
                                                        <img src="{{ asset('assets/img/icons/play.svg') }}" class="me-2" alt="Play" />
                                                        {{ $lecture['title']}}
                                                    </p>
                                                    <div class="d-flex gap-3">
                                                        <a href="{{ $lecture['previewUrl'] }}" class="text-primary text-decoration-none">Preview</a>
                                                        <span>{{ $lecture['duration'] }}</span>
                                                    </div>
                                                </li>
                                                @endforeach

                                                @endforeach
                                                <!-- <li class="p-3 d-flex justify-content-between align-items-center border-bottom">
                                                    <p class="mb-0 d-flex align-items-center">
                                                        <img src="assets/img/icons/play.svg" class="me-2" alt="Play" />
                                                        Lecture1.1 Introduction to the User Experience Course
                                                    </p>
                                                    <div class="d-flex gap-3">
                                                        <a href="#" class="text-primary text-decoration-none">Preview</a>
                                                        <span>02:53</span>
                                                    </div>
                                                </li>
                                                <li class="p-3 d-flex justify-content-between align-items-center border-bottom">
                                                    <p class="mb-0 d-flex align-items-center">
                                                        <img src="assets/img/icons/play.svg" class="me-2" alt="Play" />
                                                        Lecture1.1 Introduction to the User Experience Course
                                                    </p>
                                                    <div class="d-flex gap-3">
                                                        <a href="#" class="text-primary text-decoration-none">Preview</a>
                                                        <span>02:53</span>
                                                    </div>
                                                </li>
                                                <li class="p-3 d-flex justify-content-between align-items-center border-bottom">
                                                    <p class="mb-0 d-flex align-items-center">
                                                        <img src="assets/img/icons/play.svg" class="me-2" alt="Play" />
                                                        Lecture1.1 Introduction to the User Experience Course
                                                    </p>
                                                    <div class="d-flex gap-3">
                                                        <a href="#" class="text-primary text-decoration-none">Preview</a>
                                                        <span>02:53</span>
                                                    </div>
                                                </li>
                                                <li class="p-3 d-flex justify-content-between align-items-center border-bottom">
                                                    <p class="mb-0 d-flex align-items-center">
                                                        <img src="assets/img/icons/play.svg" class="me-2" alt="Play" />
                                                        Lecture1.1 Introduction to the User Experience Course
                                                    </p>
                                                    <div class="d-flex gap-3">
                                                        <a href="#" class="text-primary text-decoration-none">Preview</a>
                                                        <span>02:53</span>
                                                    </div>
                                                </li> -->
                                                <!-- Duplicate above for other lectures -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Accordion Item 2 -->
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
                                                @foreach($course->content['sections'] as $section)
                                                <!-- Repeatable Lecture Item -->
                                                @foreach($section['lectures'] as $lecture)

                                                <li class="p-3 d-flex justify-content-between align-items-center border-bottom">
                                                    <p class="mb-0 d-flex align-items-center">
                                                        <img src="{{ asset('assets/img/icons/play.svg') }}" class="me-2" alt="Play" />
                                                        {{ $lecture['title']}}
                                                    </p>
                                                    <div class="d-flex gap-3">
                                                        <a href="{{ $lecture['previewUrl'] }}" class="text-primary text-decoration-none">Preview</a>
                                                        <span>{{ $lecture['duration'] }}</span>
                                                    </div>
                                                </li>
                                                @endforeach

                                                @endforeach
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
                                                @foreach($course->content['sections'] as $section)
                                                <!-- Repeatable Lecture Item -->
                                                @foreach($section['lectures'] as $lecture)

                                                <li class="p-3 d-flex justify-content-between align-items-center border-bottom">
                                                    <p class="mb-0 d-flex align-items-center">
                                                        <img src="{{ asset('assets/img/icons/play.svg') }}" class="me-2" alt="Play" />
                                                        {{ $lecture['title']}}
                                                    </p>
                                                    <div class="d-flex gap-3">
                                                        <a href="{{ $lecture['previewUrl'] }}" class="text-primary text-decoration-none">Preview</a>
                                                        <span>{{ $lecture['duration'] }}</span>
                                                    </div>
                                                </li>
                                                @endforeach

                                                @endforeach
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
                                                @foreach($course->content['sections'] as $section)
                                                <!-- Repeatable Lecture Item -->
                                                @foreach($section['lectures'] as $lecture)

                                                <li class="p-3 d-flex justify-content-between align-items-center border-bottom">
                                                    <p class="mb-0 d-flex align-items-center">
                                                        <img src="{{ asset('assets/img/icons/play.svg') }}" class="me-2" alt="Play" />
                                                        {{ $lecture['title']}}
                                                    </p>
                                                    <div class="d-flex gap-3">
                                                        <a href="{{ $lecture['previewUrl'] }}" class="text-primary text-decoration-none">Preview</a>
                                                        <span>{{ $lecture['duration'] }}</span>
                                                    </div>
                                                </li>
                                                @endforeach

                                                @endforeach
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
                            @foreach($course->studentReviews as $review)
                            <div class="mb-4">

                                <div class="d-flex align-items-center mb-2">
                                    <img src="{{ asset($review['icon']) }}" alt="Student" class="rounded-circle me-3" width="50" height="50">
                                    <div>
                                        <h6 class="mb-0">{{ $review['name'] }}</h6>
                                        <small class="text-muted">Verified Learner {{ $review['timeAgo'] }}</small>
                                    </div>
                                </div>
                                <p class="mb-1">“{{ $review['comment'] }}”</p>
                                <div class="text-warning fs-14">
                                    ★★★★☆
                                </div>
                            </div>
                            @endforeach


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
                                <a class="btn d-flex btn-wish" href="student-wishlist.html"><i class="isax isax-heart me-1 fs-18"></i>Add to Wishlist</a>
                                <a class="btn d-flex btn-wish" href="#"><i class="ti ti-share me-1 fs-18"></i>Share</a>
                            </div>
                            <a href="cart.html" class="btn btn-primary w-100 mt-3 btn-enroll">Enroll Now</a>
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
    </div>
</section>
<!-- /Course detail -->
@endsection