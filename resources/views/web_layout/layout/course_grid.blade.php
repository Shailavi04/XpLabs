@push('styles')
<style>
    .nav-pills .nav-link.active {
        background-color: #FF4667 !important;
        color: #fff !important;
        border-radius: 0.375rem;
        /* optional: keeps pill shape */
    }

    .nav-pills .nav-link {
        color: #333;
    }
</style>
@endpush
@section('content')

@push('scripts')
<script src="/assets/js/courseData.js"></script>
@endpush


@extends('web_layout.master')



<!-- Breadcrumb -->
@include('course_layout.home_banner')
<!-- /Breadcrumb -->

<!-- Course -->
<section class="course-content">
    <div class="container">
        <div class="row align-items-baseline">
            <div class="col">

                <!-- Filter -->
                <div class="showing-list mb-4">
                    <div class="row align-items-center">
                        <div class="col-lg-4">
                            <div class="show-result text-center text-lg-start">
                                <h6 class="fw-medium">Showing 1-9 of 50 results</h6>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="show-filter add-course-info">
                                <form action="#">
                                    <div class="d-sm-flex justify-content-center justify-content-lg-end mb-1 mb-lg-0">
                                        <div class="view-icons mb-2 mb-sm-0">
                                            <a href="{{ url('/coursesssss') }}" class="grid-view active">

                                                <span class="icon-wrapper">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-grid">
                                                        <rect x="3" y="3" width="7" height="7"></rect>
                                                        <rect x="14" y="3" width="7" height="7"></rect>
                                                        <rect x="14" y="14" width="7" height="7"></rect>
                                                        <rect x="3" y="14" width="7" height="7"></rect>
                                                    </svg>
                                                </span>
                                            </a>


                                        </div>
                                        <select class="form-select">
                                            <option>Newly Published </option>
                                            <option>Trending Courses</option>
                                            <option>Top Rated</option>
                                            <option>Free Courses</option>
                                        </select>
                                        <div class=" search-group">
                                            <i class="isax isax-search-normal-1"></i>
                                            <input type="text" class="form-control" placeholder="Search">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Filter -->

                <!-- Category Tabs -->
                <!-- Tabs (Category Buttons) -->
                <ul class="nav nav-pills mb-4 justify-content-center justify-content-lg-start" id="category-tabs">
                    <li class="nav-item">
                        <button class="nav-link active" data-category="All">All</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-category="Programming">Programming & Tech</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-category="Design">Graphics & Design</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-category="Marketing">Digital Marketing</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-category="Video">Video & Animation</button>
                    </li>
                </ul>

                <!-- Filtered cards render here -->
                <div class="row gx-3" id="courseCardsContainer"></div>


                <!-- Tab Panes -->
                <div class="tab-content mb-4" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-design" role="tabpanel" aria-labelledby="pills-design-tab">
                        <div class="row" id="designCourses">

                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-tech" role="tabpanel" aria-labelledby="pills-tech-tab">
                        <div class="row" id="techCourses">
                            <p>Tech Courses will appear here.</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-marketing" role="tabpanel" aria-labelledby="pills-marketing-tab">
                        <div class="row" id="marketingCourses">
                            <p>Marketing Courses will appear here.</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-video" role="tabpanel" aria-labelledby="pills-video-tab">
                        <div class="row" id="videoCourses">
                            <p>Video Courses will appear here.</p>
                        </div>
                    </div>
                </div>

                <div class="row gx-2" id="courseCardsContainer">
                    <!-- JS will inject cards here -->

                    @foreach($courses as $course)
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="course-item-two course-item mx-0">
                            <div class="course-img">
                                <a href="course/view/{{ $course->id }}">
                                    <img src="{{ $course->image }}" alt="{{ $course->category}}" class="img-fluid">
                                </a>
                                <div class="position-absolute start-0 top-0 d-flex align-items-start w-100 z-index-2 p-3">
                                    <a href="javascript:void(0);" class="fav-icon ms-auto"><i class="isax isax-heart"></i></a>
                                </div>
                            </div>
                            <div class="course-content">
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="d-flex align-items-center">

                                        <h6 class="title mb-2">
                                            <a href="course-details.html?id=${course.id}">{{ $course->title }}</a>
                                        </h6>

                                    </div>
                                </div>

                                <p class="d-flex align-items-center mb-3">
                                    <i class="fa-solid fa-star text-warning me-2"></i>{{ $course->rating }}
                                </p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="text-secondary mb-0">{{ $course->price }}</h5>

                                    <a href="{{ route('course.view',['id'=>$course->id]) }}" class="btn btn-dark btn-sm">
                                        View Course
                                    </a>

                                </div>
                            </div>
                        </div>

                    </div>
                    @endforeach

                </div>
                <!-- /pagination -->
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <p class="pagination-text">Page 1 of 2</p>
                    </div>
                    <div class="col-md-10">
                        <ul id="dynamicPagination" class="pagination lms-page justify-content-center justify-content-md-end mt-2 mt-md-0">

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
</section>
<!-- /Course -->


@endsection
