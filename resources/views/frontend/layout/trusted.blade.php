<!-- Favicon -->
<link rel="shortcut icon" href="{{ asset('frontend/assets/img/favicon.png') }}">
<link rel="apple-touch-icon" href="{{ asset('frontend/assets/img/apple-icon.png') }}">

<!-- Theme Settings Js -->
<script src="{{ asset('frontend/assets/js/theme-script.js') }}" type="46b520612f00df8e76cf655b-text/javascript"></script>


<!-- Fontawesome CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/fontawesome/css/all.min.css') }}">

<!-- isax css -->
<link rel="stylesheet" href="{{ asset('frontend/assets/css/iconsax.css') }}">
<!-- Feathericon CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/feather/feather.css') }}">

<!-- Slick CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/slick/slick.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/slick/slick-theme.css') }}">

<!-- Select2 CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/select2/css/select2.min.css') }}">

<!-- Swiper CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/swiper/css/swiper.min.css') }}">

<!-- Aos CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/aos/aos.css') }}">



<div class="home-five">
	<!-- Testimonial -->
	<section class="testimonial-three">
		<div class="container">
			<div class="testimonial-pattern">
				<img class="pattern-left img-fluid" alt="Img" src="{{ asset('frontend/assets/img/shapes/Vector 143.png') }}">
			</div>
			<div class="testimonial-three-content">
				@if($trustTestimonials->count())
				@foreach($trustTestimonials as $testimonial)
				<div class="row align-items-center row-gap-4">
					<div class="col-xl-6 col-lg-12 col-md-12" data-aos="fade-down">
						<div class="become-content">
							<h2 class="aos-init aos-animate">{{ $testimonial->label }}</h2>
							<h4 class="aos-init aos-animate">{{ $testimonial->title }}</h4>
						</div>
						<a href="{{ $testimonial->button_url }}" class="btn btn-white aos-init aos-animate" data-aos="fade-up">
							{{ $testimonial->button_text }}
						</a>
					</div>

					<div class="col-xl-6 col-lg-12 col-md-12" data-aos="fade-down">
						<div class="swiper-testimonial-three">
							<div class="swiper-wrapper">
								@foreach($testimonial->contents as $testimonial_sec)
								<div class="swiper-slide">
									<div class="testimonial-item-five">
										<div class="testimonial-quote">
											<img class="quote img-fluid" alt="Img" src="{{ asset('frontend/assets/img/bg/quote2.svg') }}">
											<img class="quote img-fluid" alt="Img" src="{{ asset('frontend/assets/img/bg/quote2.svg') }}">
										</div>
										<div class="testimonial-content">
											<p>{{ $testimonial_sec->about }}</p>
										</div>
										<div class="testimonial-ratings">
											<div class="rating">
												@php
												$rating = round($testimonial_sec->rating * 2) / 2;
												$fullStars = floor($rating);
												$halfStar = ($rating - $fullStars) == 0.5 ? 1 : 0;
												$emptyStars = 5 - $fullStars - $halfStar;
												@endphp

												@for ($i = 0; $i < $fullStars; $i++)
													<i class="fas fa-star filled"></i>
													@endfor

													@if ($halfStar)
													<i class="fas fa-star-half-alt filled"></i>
													@endif

													@for ($i = 0; $i < $emptyStars; $i++)
														<i class="fas fa-star"></i>
														@endfor

														<p class="d-inline-block">
															<span>{{ $testimonial_sec->rating_text ?? $testimonial_sec->rating }} / 5</span>
														</p>
											</div>
										</div>
										<div class="testimonial-users">
											<div class="imgbx">
												<img class="img-fluid" alt="Img" src="{{ asset('frontend/uploads/testimonials/' . $testimonial_sec->profile_image) }}">

											</div>
											<div class="d-block">
												<h6>{{ $testimonial_sec->name }}</h6>
												<p>{{ $testimonial_sec->designation }}</p>
											</div>
										</div>
									</div>
								</div>
								@endforeach
							</div>
							<div class="testimonial-bottom-nav">
								<div class="slide-next-btn testimonial-next-pre"><i class="fas fa-arrow-left"></i></div>
								<div class="slide-prev-btn testimonial-next-pre"><i class="fas fa-arrow-right"></i></div>
							</div>
						</div>
					</div>
				</div>
				@endforeach
				@endif


				<div class="col-xl-6 col-lg-12 col-md-12" data-aos="fade-down">
					<div class="swiper-testimonial-three">
						<div class="swiper-wrapper">

							<!-- Swiper Slide -->
							<!-- <div class="swiper-slide">
								<div class="testimonial-item-five">
									<div class="testimonial-quote">
										<img class="quote img-fluid" alt="Img" src="{{asset('frontend/frontend/assets/img/bg/quote.svg')}}">
									</div>
									<div class="testimonial-content">
										<p>

											{{ $testimonial_sec->about }}
										</p>
									</div>
									<div class="testimonial-ratings">
										<div class="rating">
											@php
											$rating = round($testimonial_sec->rating * 2) / 2;
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
													<i class="fas fa-star"></i>
													@endfor

													<p class="d-inline-block">
														<span>{{ $testimonial_sec->rating_text ?? $testimonial_sec->rating }} / 5</span>
													</p>
										</div>
									</div>

									<div class="testimonial-users">
										<div class="imgbx">
											<img class="img-fluid" alt="Img" src="frontend/assets/img/user/user-01.jpg">
										</div>
										<div class="d-block">
											<h6>{{ $testimonial_sec-> name}}</h6>
											<p>{{ $testimonial_sec->designation }}</p>
										</div>
									</div>
								</div>
							</div> -->
							<!-- /Swiper Slide -->




							<!-- Swiper Slide -->
							<!-- <div class="swiper-slide">
									<div class="testimonial-item-five">
										<div class="testimonial-quote">
											<img class="quote img-fluid" alt="Img" src="frontend/assets/img/bg/quote.svg">
										</div>
										<div class="testimonial-content">
											<p>As a writer, I’ve learned so much about structure and storytelling from my mentor. Their feedback helped me tighten up my writing and make my characters more compelling.</p>
										</div>
										<div class="testimonial-ratings">
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<p class="d-inline-block">4.5<span>ratings</span></p>
											</div>
										</div>
										<div class="testimonial-users">
											<div class="imgbx">
												<img class="" alt="Img" src="frontend/assets/img/user/user-02.jpg">
											</div>
											<div class="d-block">
												<h6>Martin Harn</h6>
												<p>Docker Development</p>
											</div>
										</div>
									</div>
								</div> -->
							<!-- /Swiper Slide -->

							<!-- Swiper Slide -->
							<!-- <div class="swiper-slide">
									<div class="testimonial-item-five">
										<div class="testimonial-quote">
											<img class="quote img-fluid" alt="Img" src="frontend/assets/img/bg/quote.svg">
										</div>
										<div class="testimonial-content">
											<p>I often felt like the mentor’s answers were too detailed, which made it hard for me to keep up. Sometimes, a simpler explanation would have helped me understand things faster.</p>
										</div>
										<div class="testimonial-ratings">
											<div class="rating">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<p class="d-inline-block">4.8<span>ratings</span></p>
											</div>
										</div>
										<div class="testimonial-users">
											<div class="imgbx">
												<img class="" alt="Img" src="frontend/assets/img/user/user-03.jpg">
											</div>
											<div class="d-block">
												<h6>Noah Aarons</h6>
												<p>Business Man</p>
											</div>
										</div>
									</div>
								</div> -->
							<!-- /Swiper Slide -->


						</div>
						<!-- <div class="testimonial-bottom-nav">
							<div class="slide-next-btn testimonial-next-pre"><i class="fas fa-arrow-left"></i></div>
							<div class="slide-prev-btn testimonial-next-pre"><i class="fas fa-arrow-right"></i></div>
						</div> -->
					</div>
				</div>
			</div>

		</div>
</div>
</section>
<!--/Testimonial -->




</div>
<!-- /Main Wrapper -->


<!-- Swiper Slider -->
<script src="{{ asset('frontend/assets/plugins/swiper/js/swiper.min.js') }}" type="46b520612f00df8e76cf655b-text/javascript"></script>



<script src="https://dreamslms.dreamstechnologies.com/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="46b520612f00df8e76cf655b-|49" defer></script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"95b47dd9afd58af1","version":"2025.6.2","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}' crossorigin="anonymous"></script>