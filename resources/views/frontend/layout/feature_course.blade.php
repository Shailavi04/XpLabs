<section class="home-five-courses">
    <div class="container">
        <div class="favourite-course-sec">
            <div class="row">
                <div class="home-five-head section-header-title aos-init aos-animate" data-aos="fade-up">
                    <div class="row align-items-center d-flex justify-content-between row-gap-4">
                        <div class="col-md-6">
                            <h2>Featured Courses</h2>
                        </div>
                        <div class="col-md-6">
                            <div class="see-all text-end">
                                <a href="{{ route('frontend.layout.course_grid') }}">View All<i class="fas fa-arrow-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="all-corses-main">
                    <div class="tab-content">

                        <div class="nav tablist-three" role="tablist">
                            <a class="nav-tab active me-3" data-bs-toggle="tab" href="javascript:void(0);" onclick="loadCourse();" role="tab" aria-selected="true">All</a>

                            <!-- @foreach ($categories as $filter ) -->
                            <a class="nav-tab me-3 category-tab"
                                href="javascript:void(0);"
                                data-id="{{ $filter->id }}">
                                {{ $filter->name }}
                            </a>

                            <!-- <a class="nav-tab me-3" data-bs-toggle="tab" href="#businesstab" role="tab" aria-selected="false" tabindex="-1">Business</a>

							<a class="nav-tab me-3" data-bs-toggle="tab" href="#designtab" role="tab" aria-selected="false" tabindex="-1">Design</a>

							<a class="nav-tab me-3" data-bs-toggle="tab" href="#designtab" role="tab" aria-selected="false" tabindex="-1">Music</a>

							<a class="nav-tab me-3" data-bs-toggle="tab" href="#programmingtab" role="tab" aria-selected="false" tabindex="-1">Programming</a>

							<a class="nav-tab me-3" data-bs-toggle="tab" href="#databasetab" role="tab" aria-selected="false" tabindex="-1">Database</a> -->
                            <!-- @endforeach -->
                        </div>



                        <div class="tab-content">

                            <!-- All -->
                            <div class="row gx-2" id="courseCardsContainer">

                                <!-- Cards will be injected here -->

                            </div>
                            <div class="text-center mt-3">
                                <a href="{{ route('frontend.layout.course_grid') }}" class="btn btn-secondary">View all Courses</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</section>
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let userWishlist = []; // store already wishlisted course IDs

    $(document).ready(function() {
        fetchWishlist(); // get user's wishlist on page load
        loadCourse(); // load courses for homepage
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

    function loadCourse(categoryId = null, isHomepage = true) {
        let data = {};
        if (categoryId) data.category_id = categoryId;
        if (isHomepage) data.homepage = 1; // limit to 10 courses only for homepage

        $.ajax({
            url: "{{ route('load-courses') }}",
            type: "GET",
            data: data,
            dataType: 'json',
            success: function(response) {
                $('#courseCardsContainer').html('');

                if (response.length === 0) {
                    $('#courseCardsContainer').html('<p class="text-center">No courses found!</p>');
                    return;
                }

                response.forEach(course => {
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
                                        <a href="javascript:void(0);" class="fav-icon ms-auto wishlist-btn" data-id="${course.id}">
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
            },
            error: function(xhr) {
                console.error("Failed to load courses", xhr);
            }
        });
    }

    // Load category-specific courses on tab click
    $(document).on('click', '.category-tab', function() {
        const categoryId = $(this).data('id');
        loadCourse(categoryId, true);
    });

    // Reload all courses when "All" tab is clicked
    $(document).on('click', '.nav-tab.active', function() {
        loadCourse(null, true);
    });

    // Toggle wishlist when heart icon is clicked
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