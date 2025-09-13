		<!-- Become An Instructor -->
		<!-- <section class="home-five-become mt-5">
			<div class="container">
				<div class="row align-items-center row-gap-4">
					<div class="col-lg-8 col-md-8" data-aos="fade-up">
						<div class="become-content-three">
							<h2>Become An Instructor</h2>
							<p>Top instructors from around the world teach millions of students on DreamsLMS.</p>
						</div>
					</div>
					<div class="col-lg-4 col-md-4" data-aos="fade-up">
						<div class="text-end">
							<a href="#" class="btn btn-white">Join Our Community</a>
						</div>
					</div>
				</div>
			</div>
		</section> -->
		<!-- /Become An Instructor -->

		<!-- Leading Companies -->
		<section class="lead-companies-three">
			<div class="container">
				<div class="home-five-head section-header-title aos-init aos-animate">
					<div class="row align-items-center d-flex justify-content-between">
						@foreach($leadingCompanies as $company)
						<div class="col-lg-12 mb-3" data-aos="fade-up">
							<h2>{{ $company->title }}</h2>
						</div>

						@php
						$images = json_decode($company->company_images, true);
						@endphp

						<div class="m-0 p-0 lead-group aos" data-aos="fade-up">
							<div class="lead-group-slider owl-carousel owl-theme">
								@if ($images && is_array($images))
								@foreach ($images as $img)
								<div class="item">
									<div class="lead-img">
										<img class="img-fluid" alt="Company Image" src="{{ asset('uploads/companies/' . $img) }}">
									</div>
								</div>
								@endforeach
								@endif
							</div>
						</div>
						@endforeach
					</div>

				</div>
			</div>
			</div>
		</section>
		<!-- /Leading Companies -->