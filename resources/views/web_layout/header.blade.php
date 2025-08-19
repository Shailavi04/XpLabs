
<header class="header-four bg-white">
	<div class="container">
		<div class="header-nav">
			<div class="navbar-header">
				<a id="mobile_btn" href="javascript:void(0);">
					<span class="bar-icon">
						<span></span>
						<span></span>
						<span></span>
					</span>
				</a>
				<div class="navbar-logo">
					<a class="logo-white header-logo" href="index.html">
						<img src="{{ asset('assets/img/icon/LightLogo.png') }}" class="logo" alt="Logo">
					</a>
					<a class="logo-dark header-logo" href="index.html">
						<img src="{{ asset('assets/img/icon/DarkLogo.png') }}" class="logo" alt="Logo">
					</a>
				</div>
			</div>
			<div class="main-menu-wrapper">
				<div class="menu-header">
					<a href="index.html" class="menu-logo">
						<img src="{{ asset('assets/img/logo.svg') }}" class="img-fluid" alt="Logo">
					</a>
					<a id="menu_close" class="menu-close" href="javascript:void(0);">
						<i class="fas fa-times"></i>
					</a>
				</div>
				<ul class="main-nav">
					<li class="has-submenu {{ request()->is('/') ? 'active' : '' }}">
						<a href="{{ route('layout.index') }}">Home</a>
					</li>
					<li class="has-submenu {{ request()->is('courses') ? 'active' : '' }}">
						<a href="{{ route('layout.course_grid') }}">Courses</a>
					</li>
					<li class="has-submenu {{ request()->is('about-us') ? 'active' : '' }}">
						<a href="{{ route('layout.aboutUs') }}">About us</a>
					</li>
					<li class="has-submenu {{ request()->is('success-story') ? 'active' : '' }}">
						<a href="{{ route('layout.success_story') }}">Success Stories</a>
					</li>
					<li class="has-submenu {{ request()->is('contact-us') ? 'active' : '' }}">
						<a href="{{ route('layout.contactUs') }}">Contact us</a>
					</li>
				</ul>

				<div class="menu-dropdown">
					<div class="cart-item">
						<h6>Cart & Wishlist</h6>
						<div class="icon-btn">
							<a href="cart.html" class="position-relative">
								<i class="isax isax-shopping-cart5"></i>
								<span class="count-icon bg-success p-1 rounded-pill text-white fs-10 fw-bold">1</span>
							</a>
						</div>
					</div>
					<div class="dropdown flag-dropdown mb-2">
						<a href="javascript:void(0);" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="assets/img/flags/us-flag.svg" class="me-2" alt="flag">ENG
						</a>

						<ul class="dropdown-menu p-2 mt-2" id="dropdown">
							<li>
								<a class="dropdown-item rounded d-flex align-items-center" href="javascript:void(0);">
									<img src="{{ asset('assets/img/flags/us-flag.svg') }}" class="me-2" alt="flag">ENG
								</a>
							</li>
							<li>
								<a class="dropdown-item rounded d-flex align-items-center" href="javascript:void(0);">
									<img src="{{ asset('assets/img/flags/arab-flag.svg') }}" class="me-2" alt="flag">ARA
								</a>
							</li>
							<li>
								<a class="dropdown-item rounded d-flex align-items-center" href="javascript:void(0);">
									<img src="{{ asset('assets/img/flags/france-flag.svg') }}" class="me-2" alt="flag">FRE
								</a>
							</li>
						</ul>
					</div>
					<div class="dropdown mb-2">
						<a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
							Light
						</a>
						<ul class="dropdown-menu p-2 mt-2">
							<li><a class="dropdown-item rounded" href="javascript:void(0);">Light</a></li>
							<li><a class="dropdown-item rounded" href="javascript:void(0);">Dark</a></li>
						</ul>
					</div>
				</div>
				<div class="menu-login">
					<a href="Apply Now.html" class="btn btn-secondary w-100"><i class="isax isax-user-edit me-2"></i>Apply Now</a>
				</div>
			</div>
			<div class="header-btn d-flex align-items-center">
				<div class="icon-btn me-2">
					<a href="javascript:void(0);" id="dark-mode-toggle" class="theme-toggle activate">
						<i class="isax isax-sun-15"></i>
					</a>
					<a href="javascript:void(0);" id="light-mode-toggle" class="theme-toggle">
						<i class="isax isax-moon"></i>
					</a>
				</div>
				<div class="dropdown flag-dropdown me-3">
					<a href="javascript:void(0);" class="dropdown-toggle d-inline-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
						<img src="{{ asset('assets/img/flags/us-flag.svg') }}" class="me-2" alt="flag">ENG
					</a>
					<ul class="dropdown-menu p-2 mt-2">
						<li>
							<a class="dropdown-item rounded d-flex align-items-center" href="javascript:void(0);">
								<img src="{{ asset('assets/img/flags/us-flag.svg') }}" class="me-2" alt="flag">ENG
							</a>
						</li>
						<li>
							<a class="dropdown-item rounded d-flex align-items-center" href="javascript:void(0);">
								<img src="{{ asset('assets/img/flags/arab-flag.svg') }}" class="me-2" alt="flag">ARA
							</a>
						</li>
						<li>
							<a class="dropdown-item rounded d-flex align-items-center" href="javascript:void(0);">
								<img src="{{ asset('assets/img/flags/france-flag.svg') }}" class="me-2" alt="flag">FRE
							</a>
						</li>
					</ul>
				</div>
				<a href="Apply Now.html" class="btn btn-secondary me-0">
					<i class="fa-solid fa-user me-2"></i>Apply Now
				</a>

			</div>
		</div>
	</div>

</header>

<!-- Bootstrap Core JS -->
<script src="assets/js/bootstrap.bundle.min.js" type="text/javascript"></script>
