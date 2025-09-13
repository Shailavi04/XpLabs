<section class="section student-course student-course-five" style="margin-top:-50px;
  z-index:10;">
	<div class="container">
		<div class="course-widget-three">
			<div class="row row-gap-4">
				
				@foreach($visions as $vision)
				@php
				preg_match('/^(\d+(?:\.\d+)?)([A-Za-z\+]+)?$/', $vision->heading, $matches);
				$number = $matches[1] ?? '0';
				$suffix = $matches[2] ?? '';
				@endphp

				<div class="col-lg-3 col-md-6 d-flex aos-init aos-animate" data-aos="fade-up">
					<div class="course-details-three">
						<div class="align-items-center">
							<div class="course-count-three course-count ms-0">
								<div class="course-img">
									<img class="img-fluid" src="{{ $vision->icon }}" alt="Img">
								</div>
								<div class="course-content-three">
									<h4>
										<span class="counterUp">{{ $number }}</span>{{ $suffix }}
									</h4>
									<p>{{ $vision->description }}</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</section>