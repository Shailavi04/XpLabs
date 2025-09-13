@extends('frontend.web_layout.master')

@section('content')

<!-- Main Wrapper -->
<div class="main-wrapper">
	<!-- Breadcrumb -->
	<div class="breadcrumb-bar text-center" style="background: url('frontend/assets/img/bg/call 1.png') no-repeat center center; background-size: cover; margin-top: 80px;">

		<div class="container">
			<div class="row">
				<div class="col-md-12 col-12">
					<h2 class="breadcrumb-title mb-2" style="color:white;">Contact Us</h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb justify-content-center mb-0">
							<li class="breadcrumb-item"><a href="{{ route('frontend.layout.index') }}" style="color:white;">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page" style="color:white;">Contact Us</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->


	<section class="contact-sec">
		<div class="container">
			@foreach ($contactUs as $contact )

			<div class="contact-info">
				<div class="row row-gap-3">
					<!-- Address info -->
					<div class="col-lg-4 col-md-6">
						<div class="card card-body border p-sm-4" style="min-height: 120px;">
							<div class="d-flex align-items-center" style="height: 100%;">
								<div class="contact-icon" style="flex-shrink: 0; width: 50px; height: 50px;">
									<span class="bg-primary fs-24 rounded-3 d-flex justify-content-center align-items-center w-100 h-100">
										<i class="isax isax-location5 text-white"></i>
									</span>
								</div>
								<div class="ps-3">
									<h5 class="mb-1">Address</h5>
									<address class="mb-0">{{ $contact->address }}</address>
								</div>
							</div>
						</div>
					</div>

					<!-- Phone info -->
					<div class="col-lg-4 col-md-6">
						<div class="card card-body border p-sm-4" style="height: 85%;">
							<div class="d-flex align-items-center">
								<div class="contact-icon">
									<span class="bg-primary fs-24 rounded-3 d-flex justify-content-center align-items-center">
										<i class="isax isax-headphone5 text-white"></i>
									</span>
								</div>
								<div class="ps-3">
									<h5 class="mb-1">Phone</h5>
									<p class="mb-0">
										<a href="#" class="text-gray-5 text-primary-hover text-decoration-underline mb-0">{{ $contact->phone }}</a>
									</p>
								</div>
							</div>
						</div>
					</div>
					<!-- Email info -->
					<div class="col-lg-4 col-md-6">
						<div class="card card-body border p-sm-4" style="height: 85%;">
							<div class="d-flex align-items-center">
								<div class="contact-icon">
									<span class="bg-primary fs-24 rounded-3 d-flex justify-content-center align-items-center">
										<i class="isax isax-message5 text-white"></i>
									</span>
								</div>
								<div class="ps-3">
									<h5 class="mb-1">E-mail Address</h5>
									<p class="mb-0">
										<a href="#" class="text-gray-5 text-primary-hover text-decoration-underline mb-0"><span class="__cf_email__" data-cfemail=""></span>{{ $contact->email_address }}</a>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="bg-light border rounded-4 p-4 p-sm-5 p-md-6">
				<div class="row align-items-center">
					<div class="col-lg-6">
						<div class="contact-details">
							<div class="section-header">
								<span class="section-badge">
									{{ $contact->title }}
								</span>
								<h2 style="color: black;">{{ $contact->heading }}</h2>
								<p>{{ $contact->decription}}</p>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="card mb-0">
							<div class="card-body p-4 p-sm-5 p-md-6">
								<h4 class="mb-3">Send Us Message</h4>

								<form action="{{ route('send.message') }}" method="POST">
									@csrf
									<div class="row">
										<div class="col-sm-6">
											<div class="mb-4">
												<label class="form-label">Name <span class="ms-1 text-danger">*</span>
												</label>
												<input type="text" name="name" class="form-control form-control-lg">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="mb-4">
												<label class="form-label">Email Address <span class="ms-1 text-danger">*</span>
												</label>
												<input type="text" name="email" class="form-control form-control-lg">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="mb-4">
												<label class="form-label">Phone Number</label>
												<input type="text" name="phone" class="form-control form-control-lg">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="mb-4">
												<label class="form-label">Subject</label>
												<input type="text" name="subject" class="form-control form-control-lg">
											</div>
										</div>
									</div>
									<div class="mb-4">
										<label class="form-label">Your Message</label>
										<textarea class="form-control form-control-lg" rows="4" name="message"></textarea>
									</div>
									<div class="d-grid">
										<button type="submit" class="btn btn-secondary btn-lg">Send Enquiry</button>
									</div>

									@if(session('success'))
									<p id="success-message" class="text-success text-center p-3">
										{{ session('success') }}
									</p>

									<script>
										setTimeout(function() {
											let msg = document.getElementById('success-message');
											if (msg) {
												msg.style.display = 'none';
											}
										}, 2000);
									</script>
									@endif

								</form>
							</div>
						</div>
					</div>
				</div>
			</div>

			@endforeach
	</section>

	<section>
		<div class="container-fluid">
			<h1 class="mb-4">Centers Map</h1>
			<div id="map" style="height: 500px; width: 100%;"></div>
		</div>
	</section>
	@endsection

@push('scripts')
<script>
    function initMap() {
        var mapCenter = {
            lat: {{ $mapCenter->latitude ?? 26.8467 }},
            lng: {{ $mapCenter->longitude ?? 80.9462 }}
        };

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 6,
            center: mapCenter
        });

        var centers = @json($centers);
        centers.forEach(function(center) {
            if (center.latitude && center.longitude) {
                new google.maps.Marker({
                    position: {
                        lat: parseFloat(center.latitude),
                        lng: parseFloat(center.longitude)
                    },
                    map: map,
                    title: center.name
                });
            }
        });
    }

    // 👇 expose function globally
    window.initMap = initMap;
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=your-api-key&callback=initMap" async defer></script>
@endpush
