	<section class="banner-section-four d-flex align-items-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 col-12" data-aos="fade-up">
					<div class="home-slide-face">
						@foreach($banners as $banner)
						<div class="banner-content">
							<h6>{{ $banner->heading}}</h6>
							<h1 style="color: black;">{{ $banner->subheading }}
							</h1>
							<p>{{ $banner-> description}}</p>
						</div>
						@endforeach
						<div class="banner-form">
							<form class="form" name="store" id="store" method="GET" action="{{ $banner->button_url }}">

								<div class="form-inner1">
									<div class="input-group">

										<!-- Dropdown inside input group using Bootstrap -->
										<div class="input-group-prepend">
											<select class="form-select" name="storeID">
												<option value="0">Select Category</option>
												<option value="1">Development</option>
												<option value="2">Marketing</option>
											</select>
										</div>

										<!-- Text input -->
										<input type="text" class="form-control" placeholder="{{ $banner->search_placeholder }}">

										<!-- Search button -->
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
								<i class="fas fa-star filled"></i>
								<i class="fas fa-star filled"></i>
								<i class="fas fa-star filled"></i>
								<i class="fas fa-star filled"></i>
								<i class="fas fa-star filled"></i>
								<span>{{ $banner->rating }} / 200 Review</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="banner-image">


						@php
						$images = json_decode($banner->main_image);
						@endphp
						
						<div class="row position-relative">
							<div class="logo-cover">
								<img src="{{ asset($images[3]) }}" alt="img" class="img-fluid img-05 d-none d-xl-flex aos" data-aos="zoom-in">
							</div>
							<div class="col-md-6 d-flex">
								<div class="flex-fill">
									<img src="{{ asset($images[0]) }}" alt="img" class="img-fluid h-100 flex-fill img-01 aos" data-aos="fade-bottom">
								</div>
							</div>
							<div class="col-md-6 d-flex flex-column">
								<div class="flex-fill mb-3">
									<img src="{{ asset($images[1]) }}" alt="img" class="img-fluid img-02 aos" data-aos="fade-down">
								</div>
								<div class="flex-fill">
									<img src="{{ asset($images[2]) }}" alt="img" class="img-fluid img-03 aos" data-aos="fade-up">
								</div>
							</div>
						</div>

						<!-- <div class="row position-relative">
							<div class="logo-cover">
								<img src="" alt="img" class="img-fluid img-05 d-none d-xl-flex aos" data-aos="zoom-in">
							</div>
							<div class="col-md-6 d-flex">
								<div class="flex-fill">
									<img src="{{ $banner->main_image }}" alt="img" class="img-fluid h-100 flex-fill img-01 aos" data-aos="fade-bottm">
								</div>
							</div>
							<div class="col-md-6 d-flex flex-column">
								<div class="flex-fill mb-3">
									<img src="" alt="img" class="img-fluid img-02 aos" data-aos="fade-down">
								</div>
								<div class="flex-fill">
									<img src="" alt="img" class="img-fluid img-03 aos" data-aos="fade-up">
								</div>
							</div>
						</div> -->
					</div>
				</div>
			</div>
			<!-- Shapes -->
			<div class="shapes">
				<img class="shapes-one" src="{{ asset('assets/img/bg/bg-10.png') }}" alt="Img">
				<img class="shapes-two" src="{{ asset('assets/img/bg/bg-11.png') }}" alt="Img">
				<img class="shapes-middle" src="{{ asset('assets/img/bg/bg-12.png') }}" alt="Img">
			</div>
			<!-- /Shapes -->
		</div>
	</section>