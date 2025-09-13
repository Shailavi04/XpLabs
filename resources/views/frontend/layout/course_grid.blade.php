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


@push('scripts')
<script src="asset{{ ('/assets/js/courseData.js') }}"></script>
@endpush


@extends('frontend.web_layout.master')

@section('content')

<!-- Breadcrumb -->
@include('frontend.course_layout.home_banner')
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
                                <h6 class="fw-medium">
                                    Showing <span id="course-count">0</span> results
                                </h6>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="show-filter add-course-info">
                                <form action="#">
                                    <div class="d-sm-flex justify-content-center justify-content-lg-end mb-1 mb-lg-0">
                                        <div class="view-icons mb-2 mb-sm-0">
                                            <a href="{{ url('/courses') }}" class="grid-view active">

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
                                        <select class="form-select" id="sortDropdown">
                                            <option value="">Sort By</option>
                                            <option value="new">Newly Published</option>
                                            <option value="trending">Trending Courses</option>
                                            <option value="top">Top Rated</option>
                                            <option value="free">Free Courses</option>
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
                <div class="nav tablist-three" role="tablist">
                    <a class="nav-tab active me-3" data-bs-toggle="tab" href="javascript:void(0);" onclick="loadCourse();" role="tab" aria-selected="true">All</a>

                    @foreach ($categories as $filter )
                    <a class="nav-tab me-3 category-tab"
                        href="javascript:void(0);"
                        data-id="{{ $filter->id }}">
                        {{ $filter->name }}
                    </a>
                    @endforeach
                </div>


                <!-- Filtered cards render here -->
                <div class="row gx-2" id="courseCardsContainer">

                    <!-- Cards will be injected here -->

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
@endsection

<!-- /Course -->
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    let allCourses = [];
    let currentPage = 1;
    const coursesPerPage = 8;
    let userWishlist = []; // store already wishlisted course IDs

    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const categoryId = urlParams.get('category_id');

        // Load initial wishlist (only if logged in)
        fetchWishlist();

        if (categoryId && categoryId != 0) {
            loadCourse(categoryId);
            $('.category-tab').removeClass('active');
            $(`.category-tab[data-id="${categoryId}"]`).addClass('active');
        } else {
            loadCourse();
        }
    });

    // Fetch wishlist of logged-in user
    function fetchWishlist() {
        $.ajax({
            url: "{{ route('wishlist.index') }}",
            type: "GET",
            dataType: "json",
            success: function(response) {
                userWishlist = response.map(item => item.course_id);
            },
            error: function(xhr) {
                console.warn("Could not fetch wishlist (maybe not logged in).");
            }
        });
    }

    // Sort dropdown change
    $(document).on('change', '#sortDropdown', function() {
        const sortValue = $(this).val();
        const urlParams = new URLSearchParams(window.location.search);
        const categoryId = urlParams.get('category_id');

        loadCourse(categoryId, sortValue);
    });

    function loadCourse(categoryId = null, sort = null) {
        let requestData = {};
        if (categoryId) requestData.category_id = categoryId;
        if (sort) requestData.sort = sort;

        $.ajax({
            url: "{{ route('load-courses') }}",
            type: "GET",
            data: requestData,
            dataType: 'json',
            success: function(response) {
                allCourses = response;
                $('#course-count').text(allCourses.length);
                currentPage = 1;
                renderCourses();
                renderPagination();
            },
            error: function(xhr) {
                console.error("Failed to load courses", xhr);
            }
        });
    }

    function renderCourses() {
        $('#courseCardsContainer').html('');
        let start = (currentPage - 1) * coursesPerPage;
        let end = start + coursesPerPage;
        let coursesToShow = allCourses.slice(start, end);

        coursesToShow.forEach(course => {
            let isWishlisted = userWishlist.includes(course.id);
            let heartIcon = isWishlisted ?
                `<i class="fa-solid fa-heart text-danger"></i>` :
                `<i class="isax isax-heart"></i>`;

            let courseHTML = `
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="course-item-two course-item mx-0">
                <div class="course-img">
                    <a href="/course/view/${course.id}">
                        <img src="/uploads/courses/${course.image}" alt="${course.name}" class="img-fluid">
                    </a>
                    <div class="position-absolute start-0 top-0 d-flex align-items-start w-100 z-index-2 p-3">
                        <a href="javascript:void(0);" 
                           class="fav-icon ms-auto wishlist-btn" 
                           data-id="${course.id}">
                           ${heartIcon}
                        </a>
                    </div>
                </div>
                <div class="course-content">
                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="title mb-2">
                            <a href="/course/view/${course.id}">${course.name}</a>
                        </h6>
                    </div>
                    <p class="d-flex align-items-center mb-3">
                        <i class="fa-solid fa-star text-warning me-2"></i>${course.rating ?? 4}
                    </p>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="text-secondary mb-0">₹${course.total_fee}</h5>
                        <a href="/course/view/${course.id}" class="btn btn-dark btn-sm">View Course</a>
                    </div>
                </div>
            </div>
        </div>`;
            $('#courseCardsContainer').append(courseHTML);
        });
    }

    function renderPagination() {
        let totalPages = Math.ceil(allCourses.length / coursesPerPage);
        $('.pagination-text').text(`Page ${currentPage} of ${totalPages}`);

        let paginationHTML = `
        <li class="page-item prev ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0)"><i class="fas fa-angle-left"></i></a>
        </li>`;

        for (let i = 1; i <= totalPages; i++) {
            paginationHTML += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="javascript:void(0)">${i}</a>
            </li>`;
        }

        paginationHTML += `
        <li class="page-item next ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0)"><i class="fas fa-angle-right"></i></a>
        </li>`;

        $('#dynamicPagination').html(paginationHTML);
    }

    // Pagination click
    $(document).on('click', '#dynamicPagination .page-item:not(.disabled) .page-link', function() {
        let parentLi = $(this).closest('.page-item');
        let text = $(this).text().trim();
        let totalPages = Math.ceil(allCourses.length / coursesPerPage);

        if (parentLi.hasClass('prev') && currentPage > 1) {
            currentPage--;
        } else if (parentLi.hasClass('next') && currentPage < totalPages) {
            currentPage++;
        } else if (!isNaN(text) && text !== '') {
            currentPage = parseInt(text);
        }

        renderCourses();
        renderPagination();
    });

    // Category tab click (AJAX filter)
    $(document).on('click', '.category-tab', function() {
        const categoryId = $(this).data('id');
        loadCourse(categoryId);

        $('.category-tab').removeClass('active');
        $(this).addClass('active');

        if (history.pushState) {
            const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + `?category_id=${categoryId}`;
            window.history.pushState({
                path: newUrl
            }, '', newUrl);
        }
    });

    // Wishlist click (toggle)
    $(document).on('click', '.wishlist-btn', function() {
        const courseId = $(this).data('id');
        const heartIcon = $(this).find('i');

        $.ajax({
            url: "{{ route('wishlist.toggle') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                course_id: courseId
            },
            success: function(response) {
                if (response.status === 'added') {
                    userWishlist.push(courseId);
                    heartIcon.removeClass().addClass('fa-solid fa-heart text-danger');
                } else if (response.status === 'removed') {
                    userWishlist = userWishlist.filter(id => id !== courseId);
                    heartIcon.removeClass().addClass('isax isax-heart');
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    alert("Please login to use wishlist.");
                } else {
                    alert("Something went wrong.");
                }
            }
        });
    });
</script>
@endpush