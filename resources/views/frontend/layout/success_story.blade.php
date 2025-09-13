@extends('frontend.web_layout.master')

@section('content')

<section class="home-slide-five">
	@foreach ($successBanners as $banner )
	<div class="container">
		<div class="row align-items-center">
			<div class="col-xl-5 col-lg-6 col-12">
				<div class="home-slide-five-face" data-aos="fade-down">

					<!-- Banner Text -->

					<div class="home-slide-five-text text-black">
						<span class="text-warning d-inline-flex fw-semibold text-uppercase mb-3">{{ $banner->heading }}</span>
						<h1 class="text-light mb-4">{{ $banner->subheading }}</h1>
						<p class="text-light fs-lg text-center text-md-start pb-2 pb-md-3 mb-4">{{ $banner->description }}</p>

					</div>
					<!-- /Banner Text -->

					<!-- banner Seach Category -->
			<div class="banner-content-five">
    <form class="form" name="store" id="store" method="GET" action="{{ route('frontend.layout.course_grid') }}">
        <div class="form-inner-five">
            <div class="input-group">
                <!-- Select Category -->
                <span class="drop-detail-five">
                    <select class="form-select select" name="category_id" onchange="this.form.submit()">
                        <option value="">Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </span>

                <!-- Search -->
                <input type="text" name="search" class="form-control" placeholder="Search for Courses">

                <!-- Submit Button -->
                <button class="btn btn-primary sub-btn" type="submit">
                    <span><i class="fa-solid fa-magnifying-glass"></i></span>
                </button>
            </div>
        </div>
    </form>
</div>

					<!-- /banner Seach Category -->

					<!-- Review and Experience -->
					<div class="review-five-group">
						<div class="review-user-five  d-flex align-items-center">
							<ul class="review-users-list">
								<li>
									<a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="leader 1"><img src="{{ asset('frontend/assets/img/user/user-01.jpg') }}" alt="img"></a>
								</li>
								<li>
									<a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="leader 2"><img src="{{ asset('frontend/assets/img/user/user-02.jpg') }}" alt="img"></a>
								</li>
								<li>
									<a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="leader 3"><img src="{{ asset('frontend/assets/img/user/user-03.jpg') }}" alt="img"></a>
								</li>
							</ul>
							<div class="review-rating-five">
								<div class="rating-star">
									@php
									$rating = round($banner->rating * 2) / 2; // round to nearest 0.5
									$fullStars = floor($rating);
									$halfStar = ($rating - $fullStars) == 0.5 ? 1 : 0;
									$emptyStars = 5 - $fullStars - $halfStar;
									@endphp

									{{-- Full Stars --}}
									@for ($i = 0; $i < $fullStars; $i++)
										<i class="fas fa-star filled"></i>
										@endfor

										{{-- Half Star --}}
										@if ($halfStar)
										<i class="fas fa-star-half-alt filled"></i>
										@endif

										{{-- Empty Stars --}}
										@for ($i = 0; $i < $emptyStars; $i++)
											<i class="far fa-star"></i>
											@endfor

											<p class="text-light mt-1">
												{{ number_format($banner->rating, 1) }} / {{ $banner->review_count ?? '200+' }} Review{{ ($banner->review_count ?? 0) > 1 ? 's' : '' }}
											</p>
								</div>

								<p class="text-light">{{ $banner->review_text }}</p>
							</div>

						</div>
					</div>
					<!-- /Review and Experience -->
				</div>
			</div>
			<div class="col-xl-7 col-lg-6 col-12">
				@php
				$images = json_decode($banner->images, true);

				//$images = json_decode(json_decode($banner->images, true), true);
				@endphp


				<div class="banner-six-img">
					<div class="row">
						<div class="col-lg-6 align-self-end">
							<div class="ban-img-1" data-aos="fade-up">
								<img src="{{ asset('frontend/'.$images[0]) }}" alt="img">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="ban-img-2" data-aos="fade-down">
								<img class="ban-shape2" data-aos="fade-down" data-aos-delay="250" src="{{ asset('frontend/assets/img/shapes/dot-group.png') }}" alt="img">
								<img class="ban-shape3" data-aos="fade-down" data-aos-delay="300" src="{{ asset('frontend/assets/img/banner/ban-shape-2.svg') }}" alt="img">
								<img class="ban-shape4" data-aos="fade-down" data-aos-delay="350" src="{{ asset('frontend/assets/img/banner/ban-shape-3.svg') }}" alt="img">
								<img src="{{ asset('frontend/'.$images[1]) }}" alt="img">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="vector-shapes-five d-none d-lg-flex">
			<img src="{{ asset('frontend/assets/img/bg/banner-vector.svg') }}" alt="Img">
		</div>
	</div>

	@endforeach
</section>


<div class="about-us">
	<div class="container">
		<div class="about-us-content">
			<div class="row align-items-center justify-content-between">
				<div class="col-lg-7 aos" data-aos="fade-up">
					<div class="about-us-head aos" data-aos="fade-up">
						<h2>What Our Learners Say About Us ❤️</h2>
						<p>See how XPLabs helped learners land global career and achieve their dream roles.</p>
					</div>
					<div class="owl-carousel owl-theme nav-bottom" id="review-carousel">
						<div class="item flex-fill">
							<div class="review-item">
								<div class="rating">
									<span><i class="ti ti-star-filled selected"></i></span>
									<span><i class="ti ti-star-filled selected"></i></span>
									<span><i class="ti ti-star-filled selected"></i></span>
									<span><i class="ti ti-star-filled selected"></i></span>
									<span><i class="ti ti-star-filled selected"></i></span>
								</div>
								<h5 class="title">"Transformed My Career"</h5>
								<p>As an employer, the platform exceeded my expectations. We swiftly found top-tier talent for our company.</p>
								<div class="d-flex align-items-center review-user">
									<div class="me-2">
										<a href="student-details.html">
											<img src="{{ asset('frontend/assets/img/user/user-06.jpg') }}" alt="img" class="img-fluid">
										</a>
									</div>
									<div>
										<h6 class=" fw-medium"><a href="student-details.html">Brenda Slaton</a></h6>
										<p class="mb-0">Designer</p>
									</div>
								</div>
							</div>
						</div>
						<div class="item flex-fill">
							<div class="review-item">
								<div class="rating">
									<span><i class="ti ti-star-filled selected"></i></span>
									<span><i class="ti ti-star-filled selected"></i></span>
									<span><i class="ti ti-star-filled selected"></i></span>
									<span><i class="ti ti-star-filled selected"></i></span>
									<span><i class="ti ti-star-filled selected"></i></span>
								</div>
								<h5 class="title">"Enhanced My Study"</h5>
								<p>The LMS made managing my coursework simple and engaging, with everything I need easily accessible and organized.</p>
								<div class="d-flex align-items-center review-user">
									<div class="me-2">
										<a href="student-details.html">
											<img src="{{ asset('frontend/assets/img/user/user-12.jpg') }}" alt="img" class="img-fluid">
										</a>
									</div>
									<div>
										<h6 class=" fw-medium"><a href="student-details.html">Adrian Dennis</a></h6>
										<p class="mb-0">Designer</p>
									</div>
								</div>
							</div>
						</div>
						<div class="item flex-fill">
							<div class="review-item">
								<div class="rating">
									<span><i class="ti ti-star-filled selected"></i></span>
									<span><i class="ti ti-star-filled selected"></i></span>
									<span><i class="ti ti-star-filled selected"></i></span>
									<span><i class="ti ti-star-filled selected"></i></span>
									<span><i class="ti ti-star-filled selected"></i></span>
								</div>
								<h5 class="title">"Transformed My Career"</h5>
								<p>As an employer, the platform exceeded my expectations. We swiftly found top-tier talent for our company.</p>
								<div class="d-flex align-items-center review-user">
									<div class="me-2">
										<a href="student-details.html">
											<img src="{{ asset('frontend/assets/img/user/user-06.jpg') }}" alt="img" class="img-fluid">
										</a>
									</div>
									<div>
										<h6 class=" fw-medium"><a href="student-details.html">Brenda Slaton</a></h6>
										<p class="mb-0">Designer</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-5">
					<div class="img-section">
						<img src="{{ asset('frontend/assets/img/feature/feature-23.jpg') }}" alt="img" class="img-fluid about-img aos" data-aos="zoom-in">
						<div class="enrolled-list-cover d-none d-xl-flex aos" data-aos="fade-down">
							<div class="enrolled-list">
								<div class="avatar-list-stacked">
									<span class="avatar avatar-rounded">
										<img class="border border-white" src="{{ asset('frontend/assets/img/user/user-01.jpg') }}" alt="img">
									</span>
									<span class="avatar avatar-rounded">
										<img class="border border-white" src="{{ asset('frontend/assets/img/user/user-35.jpg') }}" alt="img">
									</span>
									<span class="avatar avatar-rounded">
										<img class="border border-white" src="{{ asset('frontend/assets/img/user/user-09.jpg') }}" alt="img">
									</span>
									<span class="avatar avatar-rounded">
										<img class="border border-white" src="{{ asset('frontend/assets/img/user/user-06.jpg') }}" alt="img">
									</span>
									<span class="avatar avatar-rounded">
										<img src="{{ asset('frontend/assets/img/user/user-36.jpg') }}" alt="img">
									</span>
								</div>
								<p class="mb-0 text-white fw-bold text-center"><span class="text-secondary">200+ </span>Reviews</p>
							</div>
						</div>
						<img src="{{ asset('frontend/assets/img/bg/arrow.png') }}" alt="img" class="img-fluid arrow d-none d-xl-flex">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<!-- counter trending section -->
<section class="counter-trending-cover">
	<div class="container">
		<div class="counter-section">
			<div class="section-header text-center aos" data-aos="fade-up">
				<h2 class="text-white">Global Growth. Measurable Impact.</h2>
				<p class="text-white">Each number reflects global success through expert-led learning, real projects, and trusted XPLabs certification.</p>
			</div>
			<div class="row row-gap-4">
				<div class="col-md-6 col-lg-3 d-flex">
					<div class="counter-item text-center flex-fill" data-aos="fade-up">
						<h2 class="text-white">253,085+</h2>
						<p class="text-white">Learners Empowered Worldwide</p>
					</div>
				</div>
				<div class="col-md-6 col-lg-3 d-flex">
					<div class="counter-item text-center flex-fill" data-aos="fade-up">
						<h2 class="text-white">1,200+</h2>
						<p class="text-white">Industry-Relevant Courses Delivered</p>
					</div>
				</div>
				<div class="col-md-6 col-lg-3 d-flex">
					<div class="counter-item aos text-center flex-fill" data-aos="fade-up">
						<h2 class="text-white">56</h2>
						<p class="text-white">Countries Represented by Our Students</p>
					</div>
				</div>
				<div class="col-md-6 col-lg-3 d-flex">
					<div class="counter-item no-border aos text-center flex-fill" data-aos="fade-up">
						<h2 class="text-white">968+</h2>
						<p class="text-white">Subject Experts & Industry Leaders</p>
					</div>
				</div>
			</div>
			<img src="{{ asset('frontend/assets/img/bg/count-icon.png') }}" alt="img" class="img-fluid counter-bg-01 d-none d-lg-flex">
			<img src="{{ asset('frontend/assets/img/icons/banner-icon-03.svg') }}" alt="img" class="img-fluid counter-bg-02 d-none d-lg-flex">
		</div>
	</div>
	<img src="{{ asset('frontend/assets/img/bg/instructor-bg-1.png') }}" alt="img" class="instructor-bg">
</section>
<!-- /counter trending section -->

<!-- testimonials -->
<div class="testimonials-section testimonials-sec-one text-center">
	@foreach($successTestimonials as $testimonial)

	<div class="container">
		<div class="section-header text-center" data-aos="fade-up">
			<span class="fw-medium text-secondary text-decoration-underline mb-2 d-inline-block">{{ $testimonial->label }}</span>
			<h2>{{ $testimonial->title }}</h2>
			<p>{{ $testimonial->subtitle }}</p>
		</div>
		<div class="testimonials-slider lazy mt-4">

			@foreach ( $testimonial->contents as $content )

			<div>
				<div class="testimonials-item rounded-3 bg-white" data-aos="flip-right">
					<div class="position-relative d-inline-flex">
						<div class="avatar rounded-circle avatar-xxl border border-white border-3">
							<a href="student-details.html"><img class="img-fluid rounded-circle" src="{{ asset('frontend/uploads/testimonials/' . $content->profile_image) }}" alt="img"></a>
						</div>
						<i class="isax isax-quote-up5 bg-secondary quote rounded-pill fs-16 p-1"></i>
					</div>
					<h6 class="mb-1"><a href="student-details.html">{{ $content-> name}}</a></h6>
					<p class="designation">{{ $content->designation }}</p>
					<p class="mb-3 text-truncate line-clamb-2">{{ $content->review}}</p>
					<div class="testimonial-ratings mt-2">
						<div class="rating d-inline-flex align-items-center gap-1">
							@php
							$rating = round($content->rating * 2) / 2;
							$fullStars = floor($rating);
							$halfStar = ($rating - $fullStars) == 0.5 ? 1 : 0;
							$emptyStars = 5 - $fullStars - $halfStar;
							@endphp

							{{-- Full Stars --}}
							@for ($i = 0; $i < $fullStars; $i++)
								<i class="fa-solid fa-star text-warning"></i>
								@endfor

								{{-- Half Star --}}
								@if ($halfStar)
								<i class="fa-solid fa-star-half-stroke text-warning"></i>
								@endif

								{{-- Empty Stars --}}
								@for ($i = 0; $i < $emptyStars; $i++)
									<i class="fa-regular fa-star text-warning"></i>
									@endfor

						</div>
					</div>
				</div>
			</div>

			@endforeach


		</div>
	</div>
	@endforeach
</div>
<!-- testimonials -->



<!-- trusted companies -->
<div class="section lead-companies" style="margin-top: 32px; margin-bottom: 32px;">
	@foreach($hiringCompanies as $companies)
	<div class="container">
		<div class="section-header text-center aos" data-aos="fade-up">
			<h2 class="mb-0">{{ $companies->title }}</h2>
		</div>

		@php
		$images = json_decode($companies->company_images, true);
		@endphp

		@if ($images && is_array($images))
		<div class="lead-group aos" data-aos="fade-up">
			<div class="lead-group-slider owl-carousel owl-theme">
				@foreach ($images as $img)
				<div class="item">
					<div class="lead-img">
						<img class="img-fluid" alt="Img" src="{{ asset('/uploads/companies/'.$img) }}">
					</div>
				</div>
				@endforeach
			</div>
		</div>
		@endif
	</div>
	@endforeach
</div>
<!-- /trusted companies -->

@endsection