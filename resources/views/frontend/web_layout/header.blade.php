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
					<a class="logo-white header-logo" href="{{  route('frontend.layout.index') }} ">
						<img src="{{ asset('frontend/assets/img/icon/LightLogo.png') }}" class="logo" alt="Logo">
					</a>
					<a class="logo-dark header-logo" href="{{  route('frontend.layout.index') }} ">
						<img src="{{ asset('frontend/assets/img/icon/DarkLogo.png') }}" class="logo" alt="Logo">
					</a>
				</div>
			</div>
			<div class="main-menu-wrapper">
				<div class="menu-header">
					<a class="logo-white header-logo" href="{{  route('frontend.layout.index') }} ">
						<img src="{{ asset('frontend/assets/img/icon/LightLogo.png') }}" class="logo" alt="Logo">
					</a>
					<a class="logo-dark header-logo" href="{{  route('frontend.layout.index') }} ">
						<img src="{{ asset('frontend/assets/img/icon/DarkLogo.png') }}" class="logo" alt="Logo">
					</a>
					<a id="menu_close" class="menu-close" href="javascript:void(0);">
						<i class="fas fa-times"></i>
					</a>
				</div>
				<ul class="main-nav">
					<li class="{{ request()->is('/') ? 'active' : '' }}">
						<a href="{{ route('frontend.layout.index') }}">Home</a>
					</li>
					<li class="{{ request()->is('courses') ? 'active' : '' }}">
						<a href="{{ route('frontend.layout.course_grid') }}">Courses</a>
					</li>
					<li class="{{ request()->is('about-us') ? 'active' : '' }}">
						<a href="{{ route('frontend.layout.aboutUs') }}">About us</a>
					</li>
					<li class="{{ request()->is('success-story') ? 'active' : '' }}">
						<a href="{{ route('frontend.layout.success_story') }}">Success Stories</a>
					</li>
					<li class="{{ request()->is('contact-us') ? 'active' : '' }}">
						<a href="{{ route('frontend.layout.contactUs') }}">Contact us</a>
					</li>
				</ul>

				<div class="menu-dropdown">
					<div class="cart-item">
						<h6>Cart & Wishlist</h6>
						<div class="icon-btn">
							<a href="{{ route('frontend.layout.cart') }}" class="position-relative">
								<i class="isax isax-shopping-cart5"></i>
								<span class="count-icon bg-success p-1 rounded-pill text-white fs-10 fw-bold">1</span>
							</a>
						</div>
					</div>
					

				</div>
				<div class="menu-login">
					<a href="{{ route('frontend.layout.register') }}" class="btn btn-secondary w-100"><i class="isax isax-user-edit me-2"></i>Login</a>
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

				{{-- If user is NOT logged in --}}
				@guest
				<a href="{{ route('frontend.layout.register') }}" class="btn btn-secondary me-0">
					<i class="fa-solid fa-user me-2"></i> Login
				</a>
				@endguest

				{{-- If user IS logged in --}}
				@auth
				<div class="dropdown">
					<a href="javascript:void(0);" class="d-flex align-items-center" data-bs-toggle="dropdown">
						<span class="avatar">
							<img src="{{ asset('frontend/assets/img/icon/user-05.png') }}"
								alt="User Image" class="img-fluid rounded-circle" width="40" height="40">
						</span>
						
					</a>

					<ul class="dropdown-menu dropdown-menu-end">
						<li>
							<a class="dropdown-item" href="{{ route('frontend.dashboards.studentProfile') }}">
								<i class="bi bi-person me-2"></i> Profile
							</a>
						</li>
						<li>
							<a class="dropdown-item" href="{{ route('frontend.dashboards.studentDashboard') }}">
								<i class="bi bi-speedometer2 me-2"></i> Dashboard
							</a>
						</li>
						<li>
							<hr class="dropdown-divider">
						</li>
						<li>
							<form action="{{ route('logout') }}" method="POST">
								@csrf
								<button type="submit" class="dropdown-item">
									<i class="bi bi-box-arrow-right me-2"></i> Logout
								</button>
							</form>
						</li>
					</ul>
				</div>

				@endauth
			</div>

		</div>
	</div>

</header>

<!-- Bootstrap Core JS -->

<script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
