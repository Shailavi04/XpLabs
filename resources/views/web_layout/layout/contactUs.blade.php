@extends('web_layout.master')

@section('content')

		<!-- Main Wrapper -->
		<div class="main-wrapper">
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar text-center" style="background: url('/assets/img/bg/call 1.png') no-repeat center center; background-size: cover; margin-top: 80px;">

				<div class="container">
					<div class="row">
						<div class="col-md-12 col-12">
							<h2 class="breadcrumb-title mb-2" style="color:white;">Contact Us</h2>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb justify-content-center mb-0">
									<li class="breadcrumb-item"><a href="{{ route('layout.index') }}" style="color:white;">Home</a></li>
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
            		<div class="contact-info">
            			<div class="row row-gap-3">
            				<!-- Address info -->
            				<div class="col-lg-4 col-md-6">
            					<div class="card card-body border p-sm-4">
            						<div class="d-flex align-items-center">
            							<div class="contact-icon">
            								<span class="bg-primary fs-24 rounded-3 d-flex justify-content-center align-items-center">
            									<i class="isax isax-location5 text-white"></i>
            								</span>
            							</div>
            							<div class="ps-3">
            								<h5 class="mb-1">Address</h5>
            								<address class="mb-0">1364 Still Water Dr, AK 99801.</address>
            							</div>
            						</div>
            					</div>
            				</div>
            				<!-- Phone info -->
            				<div class="col-lg-4 col-md-6">
            					<div class="card card-body border p-sm-4">
            						<div class="d-flex align-items-center">
            							<div class="contact-icon">
            								<span class="bg-primary fs-24 rounded-3 d-flex justify-content-center align-items-center">
            									<i class="isax isax-headphone5 text-white"></i>
            								</span>
            							</div>
            							<div class="ps-3">
            								<h5 class="mb-1">Phone</h5>
            								<p class="mb-0">
            									<a href="#" class="text-gray-5 text-primary-hover text-decoration-underline mb-0">+1 (907) 789-7623</a>
            								</p>
            							</div>
            						</div>
            					</div>
            				</div>
            				<!-- Email info -->
            				<div class="col-lg-4 col-md-6">
            					<div class="card card-body border p-sm-4">
            						<div class="d-flex align-items-center">
            							<div class="contact-icon">
            								<span class="bg-primary fs-24 rounded-3 d-flex justify-content-center align-items-center">
            									<i class="isax isax-message5 text-white"></i>
            								</span>
            							</div>
            							<div class="ps-3">
            								<h5 class="mb-1">E-mail Address</h5>
            								<p class="mb-0">
            									<a href="#" class="text-gray-5 text-primary-hover text-decoration-underline mb-0"><span class="__cf_email__" data-cfemail="c1a2aeafb5a0a2b581a4b9a0acb1ada4efa2aeac">[email&#160;protected]</span></a>
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
											Contact Us
										</span>
										<h2 style="color: black;">Get in touch with us today</h2>
										<p>Get in touch with us to explore how our LMS solution can enhance your e-learning experience. We're here to help you build a seamless and engaging learning platform!</p>
									</div>
            					</div>
            				</div>
            				<div class="col-lg-6">
            					<div class="card mb-0">
            						<div class="card-body p-4 p-sm-5 p-md-6">
            							<h4 class="mb-3">Send Us Message</h4>
            							<form>
            								<div class="row">
            									<div class="col-sm-6">
            										<div class="mb-4">
            											<label class="form-label">Name <span class="ms-1 text-danger">*</span>
            											</label>
            											<input type="text" class="form-control form-control-lg">
            										</div>
            									</div>
            									<div class="col-sm-6">
            										<div class="mb-4">
            											<label class="form-label">Email Address <span class="ms-1 text-danger">*</span>
            											</label>
            											<input type="text" class="form-control form-control-lg">
            										</div>
            									</div>
            								</div>
            								<div class="row">
            									<div class="col-sm-6">
            										<div class="mb-4">
            											<label class="form-label">Phone Number</label>
            											<input type="text" class="form-control form-control-lg">
            										</div>
            									</div>
            									<div class="col-sm-6">
            										<div class="mb-4">
            											<label class="form-label">Subject</label>
            											<input type="text" class="form-control form-control-lg">
            										</div>
            									</div>
            								</div>
            								<div class="mb-4">
            									<label class="form-label">Your Message</label>
            									<textarea class="form-control form-control-lg" rows="4"></textarea>
            								</div>
            								<div class="d-grid">
            									<button type="submit" class="btn btn-secondary btn-lg">Send Enquiry</button>
            								</div>
            							</form>
            						</div>
            					</div>
            				</div>
            			</div>
            		</div>
            		<div class="contact-map rounded-4 overflow-hidden">
            			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d40686.62603646482!2d-74.03208057194338!3d40.71688115980892!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sin!4v1738829223631!5m2!1sen!2sin" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            		</div>
            	</div>
            </section>

        @endsection