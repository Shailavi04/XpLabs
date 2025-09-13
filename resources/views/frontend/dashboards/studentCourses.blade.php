@extends('frontend.web_layout.master')

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb-bar text-center" style="padding: 100px 0; margin-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title mb-2">Enrolled Courses</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('frontend.layout.index') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Enrolled Courses</li>
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
                <div class="page-title d-flex flex-wrap gap-3 align-items-center justify-content-between">
                    <h5>Enrolled Courses</h5>
                    <div class="tab-list">
                        <ul class="nav mb-0 gap-2" role="tablist">
                            <li class="nav-item mb-0" role="presentation">
                                <a href="javascript:void(0);" class="active" data-filter="enrolled">Enrolled ({{ $enrolledCount }})</a>
                            </li>
                            <li class="nav-item mb-0" role="presentation">
                                <a href="javascript:void(0);" data-filter="active">Active ({{ $activeCount }})</a>
                            </li>
                            <li class="nav-item mb-0" role="presentation">
                                <a href="javascript:void(0);" data-filter="completed">Completed ({{ $completedCount }})</a>
                            </li>
                        </ul>
                    </div>


                </div>

                <div id="courseCardsContainer" class="row gx-3">
                    <!--Enrolled Courses will be render here-->
                </div>


                <!-- /pagination -->
                <div class="row align-items-center mt-3">
                    <div class="col-md-2">
                        <p class="pagination-text">Page 1 of 1</p>
                    </div>
                    <div class="col-md-10">
                        <ul id="dynamicPagination" class="pagination lms-page justify-content-center justify-content-md-end mt-2 mt-md-0">
                            <!-- Pagination items will be injected here -->
                        </ul>
                    </div>
                </div>
                <!-- /pagination -->

            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let allCourses = [];
    let filteredCourses = [];
    let currentPage = 1;
    const coursesPerPage = 3;
    let activeFilter = 'enrolled'; // default tab

    $(document).ready(function() {
        loadStudentCourses();

        // Handle tab clicks for filtering
        $('.tab-list a').on('click', function() {
            activeFilter = $(this).data('filter');
            currentPage = 1;
            applyFilter();
            renderCourses();
            renderPagination();
        });
    });

    function loadStudentCourses() {
        $.ajax({
            url: "{{ route('get.student.courses') }}",
            type: "GET",
            dataType: 'json',
            success: function(response) {
                allCourses = response.courses || [];
                const counts = response.counts;

                // If no courses enrolled, show SweetAlert
                if (allCourses.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops!',
                        text: 'You haven’t enrolled in any courses yet.',
                        confirmButtonText: 'Purchase Now'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('frontend.layout.course_grid') }}";
                        }
                    });
                    return;
                }

                $('a[data-filter="enrolled"]').text(`Enrolled (${counts.enrolled})`);
                $('a[data-filter="active"]').text(`Active (${counts.active})`);
                $('a[data-filter="completed"]').text(`Completed (${counts.completed})`);

                applyFilter();
                renderCourses();
                renderPagination();
            },
            error: function(xhr) {
                console.error("Failed to load courses", xhr);
            }
        });
    }

    function applyFilter() {
        if (activeFilter === 'enrolled') {
            filteredCourses = allCourses;
        } else if (activeFilter === 'active') {
            filteredCourses = allCourses.filter(course => course.status === 'active');
        } else if (activeFilter === 'completed') {
            filteredCourses = allCourses.filter(course => course.status === 'completed');
        }
    }

    function renderCourses() {
        $('#courseCardsContainer').html('');
        let start = (currentPage - 1) * coursesPerPage;
        let end = start + coursesPerPage;
        let coursesToShow = filteredCourses.slice(start, end);

        if (coursesToShow.length === 0) {
            $('#courseCardsContainer').html('<p>No courses found.</p>');
            return;
        }

        coursesToShow.forEach(course => {
            let courseHTML = `
<div class="col-lg-4 col-md-6 mb-4">
    <div class="course-item-two course-item mx-0">
        <div class="course-img position-relative">
            <a href="/course/view/${course.id}">
                <img src="/uploads/courses/${course.image}" alt="${course.name}" class="img-fluid">
            </a>
            <a href="javascript:void(0);" class="fav-icon position-absolute top-0 end-0 m-2">
                <i class="isax isax-heart"></i>
            </a>
        </div>
        <div class="course-content p-3">
            <h6 class="title mb-2">
                <a href="/course/view/${course.id}">${course.name}</a>
            </h6>
            <p class="d-flex align-items-center mb-3">
                <i class="fa-solid fa-star text-warning me-2"></i>${course.rating ?? 4}
            </p>
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="text-secondary mb-0">Enrolled</h5>
                <a href="/course/view/${course.id}" class="btn btn-dark btn-sm">View Schedule</a>
            </div>
        </div>
    </div>
</div>`;
            $('#courseCardsContainer').append(courseHTML);
        });
    }

    function renderPagination() {
        let totalPages = Math.ceil(filteredCourses.length / coursesPerPage);
        $('.pagination-text').text(`Page ${totalPages === 0 ? 0 : currentPage} of ${totalPages}`);

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
        <li class="page-item next ${currentPage === totalPages || totalPages === 0 ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0)"><i class="fas fa-angle-right"></i></a>
        </li>`;

        $('#dynamicPagination').html(paginationHTML);
    }

    // Pagination click
    $(document).on('click', '#dynamicPagination .page-item:not(.disabled) .page-link', function() {
        let parentLi = $(this).closest('.page-item');
        let text = $(this).text().trim();
        let totalPages = Math.ceil(filteredCourses.length / coursesPerPage);

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
</script>
@endpush