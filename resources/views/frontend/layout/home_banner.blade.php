	<section class="banner-section-four d-flex align-items-center">
		<div class="container">
			<div class="row align-items-center">
				@foreach($banners as $banner)
				@php
				// images = json_decode($banner->images, true);
				$images = json_decode($banner->images,  true);

				@endphp
				<div class="col-lg-6 col-12" data-aos="fade-up">
					<div class="home-slide-face">
						<div class="banner-content">
							<h6>{{ $banner->heading }}</h6>
							<h1 style="color: black;">{{ $banner->subheading }}</h1>
							<p>{{ $banner->description }}</p>
						</div>
						<div class="banner-form">
							<form class="form" name="store" id="store" method="GET" action="{{ route('frontend.layout.course_grid') }}">
								<div class="form-inner1">
									<div class="input-group">
										<div class="input-group-prepend">
											<select class="form-select" name="category_id" id="categorySelect">
												<option value="0">Select Category</option>
												@foreach ($categories as $category)
												<option value="{{ $category->id }}">{{ $category->name }}</option>
												@endforeach
											</select>
										</div>

										<input type="text" class="form-control" placeholder="{{ $banner->search_placeholder }}">
										<button class="btn btn-secondary sub-btn1" type="submit">
											<i class="fa-solid fa-magnifying-glass me-2"></i>{{ $banner->button_text }}
										</button>
									</div>
								</div>
							</form>
						</div>

						<div class="trust-user">
							<p style="color: black;">{{ $banner->review_text }}</p>
							<div class="rating">
								@php
								$rating = round((float)$banner->rating * 2) / 2;
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

										<span>{{ $banner->rating }} / 200 Review</span>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="banner-image">
						<div class="row position-relative">
							<div class="logo-cover">
								<img src="{{ asset('frontend/'.$images[3] ?? '') }}" alt="img" class="img-fluid img-05 d-none d-xl-flex aos" data-aos="zoom-in">
							</div>
							<div class="col-md-6 d-flex">
								<div class="flex-fill">
									<img src="{{ asset('frontend/'.$images[0] ?? '') }}" alt="img" class="img-fluid h-100 flex-fill img-01 aos" data-aos="fade-bottom">
								</div>
							</div>
							<div class="col-md-6 d-flex flex-column">
								<div class="flex-fill mb-3">
									<img src="{{ asset('frontend/'.$images[1] ?? '') }}" alt="img" class="img-fluid img-02 aos" data-aos="fade-down">
								</div>
								<div class="flex-fill">
									<img src="{{ asset('frontend/'.$images[2] ?? '') }}" alt="img" class="img-fluid img-03 aos" data-aos="fade-up">
								</div>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>

			<!-- Shapes -->
			<div class="shapes">
				<img class="shapes-one" src="{{ asset('frontend/'.'assets/img/bg/bg-10.png') }}" alt="Img">
				<img class="shapes-two" src="{{ asset('frontend/'.'assets/img/bg/bg-11.png') }}" alt="Img">
				<img class="shapes-middle" src="{{ asset('frontend/'.'assets/img/bg/bg-12.png') }}" alt="Img">
			</div>
			<!-- /Shapes -->
		</div>
	</section>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Redirect on category select change to filtered course page with category_id param
    $('#categorySelect').on('change', function() {
        let categoryId = $(this).val();
        if (categoryId && categoryId != 0) {
            window.location.href = "/courses?category_id=" + categoryId;
        } else {
            // If "Select Category" chosen, just go to /courses without filter
            window.location.href = "/courses";
        }
    });
</script>