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
								<a href="#">View All<i class="fas fa-arrow-right ms-2"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="all-corses-main">
					<div class="tab-content">
						<div class="nav tablist-three" role="tablist">
							<a class="nav-tab active me-3" data-bs-toggle="tab" href="#alltab" role="tab" aria-selected="true">All</a>
							<a class="nav-tab me-3" data-bs-toggle="tab" href="#mostpopulartab" role="tab" aria-selected="false" tabindex="-1">Most popular</a>

							<a class="nav-tab me-3" data-bs-toggle="tab" href="#businesstab" role="tab" aria-selected="false" tabindex="-1">Business</a>

							<a class="nav-tab me-3" data-bs-toggle="tab" href="#designtab" role="tab" aria-selected="false" tabindex="-1">Design</a>

							<a class="nav-tab me-3" data-bs-toggle="tab" href="#designtab" role="tab" aria-selected="false" tabindex="-1">Music</a>

							<a class="nav-tab me-3" data-bs-toggle="tab" href="#programmingtab" role="tab" aria-selected="false" tabindex="-1">Programming</a>

							<a class="nav-tab me-3" data-bs-toggle="tab" href="#databasetab" role="tab" aria-selected="false" tabindex="-1">Database</a>

						</div>

						<div class="tab-content">

							<!-- All -->
							<div class="row gx-2" id="courseCardsContainer">
								<!-- Cards will be injected here -->
								@foreach($courses as $course)
								<div class="col-xl-3 col-md-6 mb-4">
									<div class="course-item-two course-item mx-0">
										<div class="course-img">
											<a href="course/view/{{ $course->id }}">
												<img src="{{ $course->image }}" alt="{{ $course->category}}" class="img-fluid">
											</a>
											<div class="position-absolute start-0 top-0 d-flex align-items-start w-100 z-index-2 p-3">
												<a href="javascript:void(0);" class="fav-icon ms-auto"><i class="isax isax-heart"></i></a>
											</div>
										</div>
										<div class="course-content">
											<div class="d-flex justify-content-between mb-2">
												<div class="d-flex align-items-center">

													<h6 class="title mb-2">
														<a href="course-details.html?id=${course.id}">{{ $course->title }}</a>
													</h6>

												</div>
											</div>

											<p class="d-flex align-items-center mb-3">
												<i class="fa-solid fa-star text-warning me-2"></i>{{ $course->rating }}
											</p>
											<div class="d-flex align-items-center justify-content-between">
												<h5 class="text-secondary mb-0">{{ $course->price }}</h5>

												<a href="{{ route('course.view',['id'=>$course->id]) }}" class="btn btn-dark btn-sm">
													View Course
												</a>

											</div>
										</div>
									</div>

								</div>
								@endforeach
							</div>
						<div class="text-center mt-3">
							<a href="#" class="btn btn-secondary">View all Courses</a>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>