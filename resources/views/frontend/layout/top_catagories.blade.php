<!-- Favourite Course -->
<section class="home-five-favourite">
	<div class="container">
		<div class="category-sec">
			<div class="row">
				<div class="container">
					<div class="home-five-head section-header-title" data-aos="fade-up">
						<div class="row align-items-center d-flex justify-content-between row-gap-4">
							<div class="col-md-8 col-sm-12">
								<h2>Choose favourite Course from top Category</h2>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="see-all text-end">
									<a href="#">View All<i class="fas fa-arrow-right ms-2"></i></a>
								</div>
							</div>
						</div>
					</div>
					<div class="favourite-carousel">
						@foreach($categories as $category)


						<!-- </div> -->
						<div class="categories-item categories-item-five" data-aos="fade-down">
							<div class="categories-icon">
								<img class="img-fluid" src="{{ asset('/frontend/uploads/category/' . $category->photo)}}" alt="Angular Development">
							</div>
							<div class="category-info">
								<h3><a href="course-category.html"> {{ $category->name }}</a></h3>
							</div>

						</div>

						@endforeach

					</div>
				</div>
			</div>
		</div>
		<!-- /Favourite Course -->
	</div>
</section>
<!-- Feature Course -->