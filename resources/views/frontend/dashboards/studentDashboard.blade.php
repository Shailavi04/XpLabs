@extends('frontend.web_layout.master')

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-bar text-center" style="padding: 100px 0; margin-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title mb-2">Dashboard</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('frontend.layout.index') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
                <div class="card bg-light quiz-ans-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div>
                                    <h6 style="color:black;">Quiz : Build Responsive Real World </h6>
                                    <p>Answered : 15/22</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-end">
                                    <a href="{{ route('frontend.dashboards.studentQuiz', ['studentId' => Auth::user()->student->id ?? 0]) }}" class="btn btn-primary rounded-pill">Continue Quiz</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <span class="icon-box bg-primary-transparent me-2 me-xxl-3 flex-shrink-0">
                                        <img src="frontend/assets/img/icon/graduation.svg" alt="">
                                    </span>
                                    <div>
                                        <span class="d-block">Enrolled Courses</span>
                                        <h4 class="fs-24 mt-1">{{ $enrolledCount }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <span class="icon-box bg-secondary-transparent me-2 me-xxl-3 flex-shrink-0">
                                        <img src="frontend/assets/img/icon/book.svg" alt="">
                                    </span>
                                    <div>
                                        <span class="d-block">Active Courses</span>
                                        <h4 class="fs-24 mt-1">{{ $activeCount }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <span class="icon-box bg-success-transparent me-2 me-xxl-3 flex-shrink-0">
                                        <img src="frontend/assets/img/icon/bookmark.svg" alt="">
                                    </span>
                                    <div>
                                        <span class="d-block">Completed Courses</span>
                                        <h4 class="fs-24 mt-1">{{ $completedCount }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="mb-3 fs-18">Recently Enrolled Courses</h5>
                <div class="row" id="enrollmentCourse">
                    @if($message)
                    <div class="col-12 text-center">
                        <p class="text-muted fs-16">{{ $message }}</p>
                    </div>
                    @endif
                    <!-- Courses will be injected here via AJAX if available -->
                </div>
                <div>

                    <div class="row">
                        <div class="col-xl-7">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="mb-3 border-bottom pb-3 fs-18">Recent Invoices</h5>

                                    @forelse ($payments as $payment)
                                    <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-3">
                                        <div>
                                            <h6 class="mb-1">{{ $payment->course->name ?? 'N/A' }}</h6>

                                            <div class="d-flex align-items-center">
                                                <span class="badge badge-sm bg-light border d-inline-flex me-3">
                                                    #{{ $payment->payment_id ?? 'N/A' }}
                                                </span>
                                                <p class="small">
                                                    Amount : <span class="heading-color fw-semibold">
                                                        ₹{{ number_format($payment->token_amount / 100, 2) ?? '500' }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <span class="badge fw-normal bg-success d-inline-flex align-items-center me-1">
                                                <i class="fa-solid fa-circle fs-5 me-1"></i>
                                                {{ $payment->status ?? 'Paid' }}
                                            </span>

                                            @if(!empty($payment->payment_id))
                                            <a href="{{ route('payments.receipt', ['payment_id' => $payment->payment_id]) }}" target="_blank" class="action-icon">
                                                <i class="isax isax-document-download"></i>
                                            </a>
                                            @else
                                            <span class="text-muted small ms-2">No receipt</span>
                                            @endif
                                        </div>
                                    </div>
                                    @empty
                                    <p>No invoices found.</p>
                                    @endforelse


                                </div>
                            </div>
                        </div>

                        <div class="col-xl-5">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <h5 class="mb-3 fs-18 border-bottom pb-3">Latest Quizzes</h5>

                                    @forelse($quizResults as $result)
                                    <div class="d-flex align-items-center flex-wrap flex-md-nowrap justify-content-between row-gap-2 mb-3">
                                        <div>
                                            <h6 class="mb-1">{{ $result->quiz->title ?? 'Unknown Quiz' }}</h6>
                                            <div class="d-flex align-items-center">
                                                <p>Correct Answer : {{ $result->score }}/{{ $result->quiz->questions_count ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        @php
                                        $total = $result->quiz->questions_count ?? 1;
                                        $percentage = round(($result->score / $total) * 100);
                                        $progressClass = $percentage >= 75 ? 'border-success' : ($percentage >= 40 ? 'border-warning' : 'border-danger');
                                        @endphp
                                        <div class="circle-progress flex-shrink-0" data-value='{{ $percentage }}'>
                                            <span class="progress-left">
                                                <span class="progress-bar {{ $progressClass }}"></span>
                                            </span>
                                            <span class="progress-right">
                                                <span class="progress-bar {{ $progressClass }}"></span>
                                            </span>
                                            <div class="progress-value">{{ $percentage }}%</div>
                                        </div>
                                    </div>
                                    @empty
                                    <p>No quiz attempts found.</p>
                                    @endforelse
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
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetchEnrolledCourses();

        function fetchEnrolledCourses() {
            const enrollmentContainer = $('#enrollmentCourse');

            $.ajax({
                url: "{{ route('student.enrolled-courses') }}",
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success' && res.courses.length > 0) {
                        let html = '';
                        res.courses.forEach(course => {
                            html += `
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
                        });
                        enrollmentContainer.html(html);
                    } else {
                        // SweetAlert popup if no courses
                        Swal.fire({
                            title: 'No Courses Yet!',
                            html: `<p>You haven’t enrolled in any course yet </p>
           <p>Start exploring amazing courses and boost your skills! </p>`,
                            icon: 'info',
                            confirmButtonText: 'Browse Courses',
                            allowOutsideClick: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect to courses listing page
                                window.location.href = "{{ route('frontend.layout.course_grid') }}";
                            }
                        });
                    }
                },
                error: function(err) {
                    console.error('Error fetching courses:', err);
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Something went wrong while fetching your courses.',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                }
            });
        }
    });
</script>
@endpush