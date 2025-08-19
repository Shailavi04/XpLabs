@extends('web_layout.master')

@section('content')



<section class="home-slide-five">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-xl-5 col-lg-6 col-12">
				<div class="home-slide-five-face" data-aos="fade-down">

					<!-- Banner Text -->
					<div class="home-slide-five-text text-black">
						<span class="text-warning d-inline-flex fw-semibold text-uppercase mb-3">The Leader in Online Learning</span>
						<h1 class="text-light mb-4">Engaging & Accessible Online Courses For All</h1>
						<p class="text-light fs-lg text-center text-md-start pb-2 pb-md-3 mb-4">Trusted by over 15K Users worldwide since 2022</p>
					</div>
					<!-- /Banner Text -->



					<!-- banner Seach Category -->
					<div class="banner-content-five">
						<form class="form" action="https://dreamslms.dreamstechnologies.com/html/template/course-list.html">
							<div class="form-inner-five">
								<div class="input-group">
									<!-- Slect Category -->
									<span class="drop-detail-five">
										<select class="form-select select">
											<option>Category</option>
											<option>Angular</option>
											<option>Node Js</option>
											<option>React</option>
											<option>Python</option>
										</select>
									</span>
									<!-- Slect Category -->

									<!-- Search -->
									<input type="email" class="form-control" placeholder="Search for Courses, Instructors">
									<!-- Search -->

									<!-- Submit Button -->
									<button class="btn btn-primary sub-btn" type="submit"><span><i class="fa-solid fa-magnifying-glass"></i></span></button>
									<!-- Submit Button -->

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
									<a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="leader 1"><img src="{{ asset('assets/img/user/user-01.jpg') }}" alt="img"></a>
								</li>
								<li>
									<a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="leader 2"><img src="{{ asset('assets/img/user/user-02.jpg') }}" alt="img"></a>
								</li>
								<li>
									<a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="leader 3"><img src="{{ asset('assets/img/user/user-03.jpg') }}" alt="img"></a>
								</li>
							</ul>
							<div class="review-rating-five">
								<div class="rating-star">
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<p class="text-light">4.9 / 200 Review</p>
								</div>
							</div>
						</div>
					</div>
					<!-- /Review and Experience -->
				</div>
			</div>
			<div class="col-xl-7 col-lg-6 col-12">
				<div class="banner-six-img">
					<div class="row">
						<div class="col-lg-6 align-self-end">
							<div class="ban-img-1" data-aos="fade-up">
								<img src="{{ asset('assets/img/hero/hero-7.png') }}" alt="img">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="ban-img-2" data-aos="fade-down">
								<img class="ban-shape2" data-aos="fade-down" data-aos-delay="250" src="{{ asset('assets/img/shapes/dot-group.png') }}" alt="img">
								<img class="ban-shape3" data-aos="fade-down" data-aos-delay="300" src="{{ asset('assets/img/banner/ban-shape-2.svg') }}" alt="img">
								<img class="ban-shape4" data-aos="fade-down" data-aos-delay="350" src="{{ asset('assets/img/banner/ban-shape-3.svg') }}" alt="img">
								<img src="{{ asset('assets/img/hero/hero-8.png') }}" alt="img">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="vector-shapes-five d-none d-lg-flex">
			<img src="{{ asset('assets/img/bg/banner-vector.svg') }}" alt="Img">
		</div>
	</div>
</section>


<div class="about-us">
<div class="container">
	<div class="about-us-content">
		<div class="row align-items-center justify-content-between">
			<div class="col-lg-7 aos" data-aos="fade-up">
				<div class="about-us-head aos" data-aos="fade-up">
					<h2>What People Say About Us ❤️</h2>
					<p>Read what our satisfied clients have to say about their experiences with our platform.</p>
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
										<img src="assets/img/user/user-06.jpg" alt="img" class="img-fluid">
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
										<img src="assets/img/user/user-12.jpg" alt="img" class="img-fluid">
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
										<img src="assets/img/user/user-06.jpg" alt="img" class="img-fluid">
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
					<img src="assets/img/feature/feature-23.jpg" alt="img" class="img-fluid about-img aos" data-aos="zoom-in">
					<div class="enrolled-list-cover d-none d-xl-flex aos" data-aos="fade-down">
						<div class="enrolled-list">
							<div class="avatar-list-stacked">
								<span class="avatar avatar-rounded">
									<img class="border border-white" src="assets/img/user/user-01.jpg" alt="img">
								</span>
								<span class="avatar avatar-rounded">
									<img class="border border-white" src="assets/img/user/user-35.jpg" alt="img">
								</span>
								<span class="avatar avatar-rounded">
									<img class="border border-white" src="assets/img/user/user-09.jpg" alt="img">
								</span>
								<span class="avatar avatar-rounded">
									<img class="border border-white" src="assets/img/user/user-06.jpg" alt="img">
								</span>
								<span class="avatar avatar-rounded">
									<img src="assets/img/user/user-36.jpg" alt="img">
								</span>
							</div>
							<p class="mb-0 text-white fw-bold text-center"><span class="text-secondary">200+ </span>Reviews</p>
						</div>
					</div>
					<img src="assets/img/bg/arrow.png" alt="img" class="img-fluid arrow d-none d-xl-flex">
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
			<img src="assets/img/bg/count-icon.png" alt="img" class="img-fluid counter-bg-01 d-none d-lg-flex">
			<img src="assets/img/icons/banner-icon-03.svg" alt="img" class="img-fluid counter-bg-02 d-none d-lg-flex">
		</div>
	</div>
	<img src="assets/img/bg/instructor-bg-1.png" alt="img" class="instructor-bg">
</section>
<!-- /counter trending section -->


<!-- trusted companies -->
<div class="section lead-companies" style="margin-top: 32px; margin-bottom: 32px;">
	<div class="container">
		<div class="section-header text-center aos aos-init aos-animate" data-aos="fade-up">
			<h2 class="mb-0">Our Hiring Partners</h2>
		</div>
		<div class="lead-group aos aos-init aos-animate" data-aos="fade-up">
			<div class="lead-group-slider owl-carousel owl-theme owl-loaded owl-drag">
				<div class="owl-stage-outer">
					<div class="owl-stage" style="transform: translate3d(-1320px, 0px, 0px); transition: all; width: 3960px;">
						<div class="owl-item cloned" style="width: 196px; margin-right: 24px;">
							<div class="item">
								<div class="lead-img">
									<img class="img-fluid" alt="Img" src="{{ asset('assets/img/client/22.svg') }}">
								</div>
							</div>
						</div>
						<div class="owl-item cloned" style="width: 196px; margin-right: 24px;">
							<div class="item">
								<div class="lead-img">
									<img class="img-fluid" alt="Img" src="{{ asset('assets/img/client/23.svg') }}">
								</div>
							</div>
						</div>
						<div class="owl-item cloned" style="width: 196px; margin-right: 24px;">
							<div class="item">
								<div class="lead-img">
									<img class="img-fluid" alt="Img" src="assets/img/client/24.svg">
								</div>
							</div>
						</div>
						<div class="owl-item cloned" style="width: 196px; margin-right: 24px;">
							<div class="item">
								<div class="lead-img">
									<img class="img-fluid" alt="Img" src="assets/img/client/25.svg">
								</div>
							</div>
						</div>
						<div class="owl-item cloned" style="width: 196px; margin-right: 24px;">
							<div class="item">
								<div class="lead-img">
									<img class="img-fluid" alt="Img" src="assets/img/client/26.svg">
								</div>
							</div>
						</div>
						<div class="owl-item cloned" style="width: 196px; margin-right: 24px;">
							<div class="item">
								<div class="lead-img">
									<img class="img-fluid" alt="Img" src="assets/img/client/27.svg">
								</div>
							</div>
						</div>
						<div class="owl-item active" style="width: 196px; margin-right: 24px;">
							<div class="item">
								<div class="lead-img">
									<img class="img-fluid" alt="Img" src="assets/img/client/22.svg">
								</div>
							</div>
						</div>
						<div class="owl-item active" style="width: 196px; margin-right: 24px;">
							<div class="item">
								<div class="lead-img">
									<img class="img-fluid" alt="Img" src="assets/img/client/23.svg">
								</div>
							</div>
						</div>
						<div class="owl-item active" style="width: 196px; margin-right: 24px;">
							<div class="item">
								<div class="lead-img">
									<img class="img-fluid" alt="Img" src="assets/img/client/24.svg">
								</div>
							</div>
						</div>
						<div class="owl-item active" style="width: 196px; margin-right: 24px;">
							<div class="item">
								<div class="lead-img">
									<img class="img-fluid" alt="Img" src="assets/img/client/25.svg">
								</div>
							</div>
						</div>
						<div class="owl-item active" style="width: 196px; margin-right: 24px;">
							<div class="item">
								<div class="lead-img">
									<img class="img-fluid" alt="Img" src="assets/img/client/26.svg">
								</div>
							</div>
						</div>
						<div class="owl-item active" style="width: 196px; margin-right: 24px;">
							<div class="item">
								<div class="lead-img">
									<img class="img-fluid" alt="Img" src="assets/img/client/27.svg">
								</div>
							</div>
						</div>
						<div class="owl-item cloned" style="width: 196px; margin-right: 24px;">
							<div class="item">
								<div class="lead-img">
									<img class="img-fluid" alt="Img" src="assets/img/client/22.svg">
								</div>
							</div>
						</div>
						<div class="owl-item cloned" style="width: 196px; margin-right: 24px;">
							<div class="item">
								<div class="lead-img">
									<img class="img-fluid" alt="Img" src="assets/img/client/23.svg">
								</div>
							</div>
						</div>
						<div class="owl-item cloned" style="width: 196px; margin-right: 24px;">
							<div class="item">
								<div class="lead-img">
									<img class="img-fluid" alt="Img" src="assets/img/client/24.svg">
								</div>
							</div>
						</div>
						<div class="owl-item cloned" style="width: 196px; margin-right: 24px;">
							<div class="item">
								<div class="lead-img">
									<img class="img-fluid" alt="Img" src="assets/img/client/25.svg">
								</div>
							</div>
						</div>
						<div class="owl-item cloned" style="width: 196px; margin-right: 24px;">
							<div class="item">
								<div class="lead-img">
									<img class="img-fluid" alt="Img" src="assets/img/client/26.svg">
								</div>
							</div>
						</div>
						<div class="owl-item cloned" style="width: 196px; margin-right: 24px;">
							<div class="item">
								<div class="lead-img">
									<img class="img-fluid" alt="Img" src="assets/img/client/27.svg">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="owl-nav disabled"><button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button><button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button></div>
				
			</div>
		</div>
	</div>
</div>
<!-- /trusted companies -->



@endsection