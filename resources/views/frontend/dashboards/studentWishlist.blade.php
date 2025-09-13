@extends('frontend.web_layout.master')

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb-bar text-center" style="padding: 100px 0; margin-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title mb-2">My Wishlist</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('frontend.layout.index') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Wishlist</li>
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

        <div class="row">
            <!-- sidebar -->
            @include('frontend.dashboards.sidebar')
            <!-- /sidebar -->

            <div class="col-lg-9">
                <div class="row">
                    @foreach($wishlistCourses as $course)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="course-item-two course-item mx-0 h-100 shadow-sm rounded-4">
                                <div class="course-img position-relative">
                                    <a href="{{ route('course.view', $course->id) }}">
                                        <img src="{{ asset('uploads/courses/'.$course->image) }}"
                                             alt="{{ $course->name }}"
                                             class="img-fluid rounded-top">
                                    </a>
                                    <div class="position-absolute start-0 top-0 d-flex align-items-start w-100 z-index-2 p-3">
                                        <a href="javascript:void(0);"
                                           class="fav-icon ms-auto wishlist-btn"
                                           data-id="{{ $course->id }}">
                                            <i class="fa-solid fa-heart text-danger"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="course-content p-3">
                                    <h6 class="title mb-2">
                                        <a href="{{ route('course.view', $course->id) }}">{{ $course->name }}</a>
                                    </h6>
                                    <p class="d-flex align-items-center mb-3">
                                        <i class="fa-solid fa-star text-warning me-2"></i>4.5
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="text-secondary mb-0">₹{{ $course->total_fee }}</h5>
                                        <a href="{{ route('course.view', $course->id) }}" class="btn btn-dark btn-sm">View Course</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($wishlistCourses->isEmpty())
                    <div class="text-center py-5">
                        <h5>No courses in your wishlist yet.</h5>
                        <a href="{{ url('/courses') }}" class="btn btn-primary mt-3">Browse Courses</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Use delegated event binding
    $(document).on('click', '.wishlist-btn', function() {
        let course_id = $(this).data('id');
        let button = $(this);

        $.ajax({
            url: "{{ route('wishlist.toggle') }}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                course_id: course_id
            },
            success: function(response) {
                if(response.status === 'removed') {
                    // Remove course card
                    button.closest('.col-lg-4').fadeOut(300, function() {
                        $(this).remove();

                        // Show empty message if no courses left
                        if($('.course-item-two').length === 0) {
                            $('.col-lg-9').html(`
                                <div class="text-center py-5">
                                    <h5>No courses in your wishlist yet.</h5>
                                    <a href="{{ url('/courses') }}" class="btn btn-primary mt-3">Browse Courses</a>
                                </div>
                            `);
                        }
                    });
                } else if(response.status === 'added') {
                    alert('Course added to wishlist!');
                }
            },
            error: function(xhr) {
                if(xhr.status === 401) {
                    alert('Please login to use wishlist.');
                } else {
                    alert('Something went wrong!');
                }
            }
        });
    });
});
</script>
@endpush

