@extends('frontend.web_layout.master')

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb-bar text-center" style="padding: 100px 0; margin-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title mb-2">Reviews</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('frontend.layout.index') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Reviews</li>
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
                <div class="page-title d-flex align-items-center justify-content-between">
                    <h5>Reviews</h5>
                </div>

                <div class="border mb-3 p-3 rounded-2">
                    <div class="d-flex flex-wrap gap-1 align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-lg avatar-rounded me-2">
                                <a href="student-details.html"><img src="assets/img/user/user-02.jpg" alt="img"></a>
                            </div>
                            <div class="reviewer-info">
                                <h6 class="mb-1"><a href="student-details.html">Ronald Richard</a></h6>
                                <p class="fs-14">6 months ago</p>
                            </div>
                        </div>
                        <div class="rating">
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                    <div class="mb-3">
                        <p>This is the second Photoshop course I have completed with Nancy Duarte.
                            Worth every penny and recommend it highly. To get the most out of this course,
                            its best to to take the Beginner to Advanced course first.
                            The sound and video quality is of a good standard. Thank you Nancy Duarte.
                        </p>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="d-inline-flex align-items-center me-3 edit-review" data-bs-toggle="modal" data-bs-target="#edit_review"><i class="isax isax-edit-2 me-1"></i>Edit</a>
                            <a href="javascript:void(0);" class="d-inline-flex align-items-center delete-review" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-1"></i>Delete</a>
                        </div>
                    </div>
                    <div class="bg-light border p-3 rounded-2">
                        <h6 class="mb-1">Reply</h6>
                        <p class="fs-14">As a learner who has navigated through various online platforms, the sophistication and user-centric design of this website set a new</p>
                    </div>
                </div>
                <div class="border mb-3 p-3 rounded-2">
                    <div class="d-flex flex-wrap gap-1 align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-lg avatar-rounded me-2">
                                <a href="student-details.html"><img src="assets/img/user/user-02.jpg" alt="img"></a>
                            </div>
                            <div class="reviewer-info">
                                <h6 class="mb-1"><a href="student-details.html">Ronald Richard</a></h6>
                                <p class="fs-14">9 months ago</p>
                            </div>
                        </div>
                        <div class="rating">
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                    <div class="mb-3">
                        <p>I've been using this LMS for several months for my online courses, and it's been
                            a game-changer. The interface is incredibly user-friendly, making it easy for both
                            instructors and students to navigate through the courses. The variety of tools available
                            for creating interactive and
                            engaging content has significantly enhanced the learning experience.
                        </p>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="d-inline-flex align-items-center me-3 edit-review" data-bs-toggle="modal" data-bs-target="#edit_review"><i class="isax isax-edit-2 me-1"></i>Edit</a>
                            <a href="javascript:void(0);" class="d-inline-flex align-items-center delete-review" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-1"></i>Delete</a>
                        </div>
                    </div>
                </div>
                <div class="border mb-3 p-3 rounded-2">
                    <div class="d-flex flex-wrap gap-1 align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-lg avatar-rounded me-2">
                                <a href="student-details.html"><img src="assets/img/user/user-02.jpg" alt="img"></a>
                            </div>
                            <div class="reviewer-info">
                                <h6 class="mb-1"><a href="student-details.html">Ronald Richard</a></h6>
                                <p class="fs-14">9 months ago</p>
                            </div>
                        </div>
                        <div class="rating">
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                    <div class="mb-3">
                        <p>Any time I've had a question or encountered a minor issue, the
                            customer support team has been quick to respond and incredibly helpful. Moreover,
                            the reliability of this LMS has impressed me—downtime is
                            nearly non-existent, ensuring that students have access to their courses 24/7.
                        </p>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="d-inline-flex align-items-center me-3 edit-review" data-bs-toggle="modal" data-bs-target="#edit_review"><i class="isax isax-edit-2 me-1"></i>Edit</a>
                            <a href="javascript:void(0);" class="d-inline-flex align-items-center delete-review" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-1"></i>Delete</a>
                        </div>
                    </div>
                </div>
                <div class="border p-3 rounded-2">
                    <div class="d-flex flex-wrap gap-1 align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-lg avatar-rounded me-2">
                                <a href="student-details.html"><img src="assets/img/user/user-02.jpg" alt="img"></a>
                            </div>
                            <div class="reviewer-info">
                                <h6 class="mb-1"><a href="student-details.html">Ronald Richard</a></h6>
                                <p class="fs-14">9 months ago</p>
                            </div>
                        </div>
                        <div class="rating">
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                    <div class="mb-3">
                        <p>From the onset, my experience with this LMS Website has been nothing
                            short of extraordinary. As a learner who has navigated through various online platforms,
                            the sophistication and user-centric design of this website
                            set a new benchmark for what digital education should look like.
                        </p>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="d-inline-flex align-items-center me-3 edit-review" data-bs-toggle="modal" data-bs-target="#edit_review"><i class="isax isax-edit-2 me-1"></i>Edit</a>
                            <a href="javascript:void(0);" class="d-inline-flex align-items-center delete-review" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-1"></i>Delete</a>
                        </div>
                    </div>
                </div>

                <!-- /pagination -->
                <div class="row align-items-center mt-3">
                    <div class="col-md-2">
                        <p class="pagination-text">Page 1 of 2</p>
                    </div>
                    <div class="col-md-10">
                        <ul class="pagination lms-page justify-content-center justify-content-md-end mt-2 mt-md-0">
                            <li class="page-item prev">
                                <a class="page-link" href="javascript:void(0)" tabindex="-1"><i class="fas fa-angle-left"></i></a>
                            </li>
                            <li class="page-item first-page active">
                                <a class="page-link" href="javascript:void(0)">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0)">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0)">3</a>
                            </li>
                            <li class="page-item next">
                                <a class="page-link" href="javascript:void(0)"><i class="fas fa-angle-right"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /pagination -->
            </div>
        </div>
    </div>
</div>

@endsection