<!DOCTYPE html> 
<html lang="en"  data-bs-theme="dark">
	<head>
	
		<!-- Meta Tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Dreams LMS is a powerful Learning Management System template designed for educators, training institutions, and businesses. Manage courses, track student progress, conduct virtual classes, and enhance e-learning experiences with an intuitive and feature-rich platform.">
		<meta name="keywords" content="LMS template, Learning Management System, e-learning software, online course platform, student management, education portal, virtual classroom, training management system, course tracking, online education">
		<meta name="author" content="Dreams Technologies">
		<meta name="robots" content="index, follow">
		
		<title>XPLabs| Advanced Learning Management System Template</title>

		<!-- Favicon -->
		<link rel="shortcut icon" href="{{asset('assets/img/favicon.png')}}"> 
		<link rel="apple-touch-icon" href="{{asset('assets/img/apple-icon.png')}}">

		<!-- Theme Settings Js -->
		<script src="{{asset('assets/js/theme-script.js')}}" type="63834a1d950dad5106effc44-text/javascript"></script>
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
		
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/fontawesome.min.css')}}">
		<link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/all.min.css')}}">

		<!-- Owl Carousel CSS -->
		<link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">

		<!-- isax css -->
		 <link rel="stylesheet" href="{{asset('assets/css/iconsax.css')}}">
		
		<!-- Slick CSS -->
		<link rel="stylesheet" href="{{asset('assets/plugins/slick/slick.css')}}">
		<link rel="stylesheet" href="{{asset('assets/plugins/slick/slick-theme.css')}}">
		
		<!-- Select2 CSS -->
		<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
		
		<!-- Aos CSS -->
		<link rel="stylesheet" href="{{asset('assets/plugins/aos/aos.css')}}">

		<!-- Main CSS -->
		<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

		@stack('styles')
	
	</head>
	<body>

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			<div class="home-4">
            @include('web_layout.header')

            @yield('content')

            @include('web_layout.footer')
     	</div>
		   
		</div>
	   <!-- /Main Wrapper -->
	  
		<!-- jQuery -->
		<script data-cfasync="false" src="https://dreamslms.dreamstechnologies.com/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="{{asset('assets/js/jquery-3.7.1.min.js')}}" type="63834a1d950dad5106effc44-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" type="63834a1d950dad5106effc44-text/javascript"></script>
		
		<!-- counterup JS -->
		<script src="{{asset('assets/js/jquery.waypoints.js')}}" type="63834a1d950dad5106effc44-text/javascript"></script>
		<script src="{{asset('assets/js/jquery.counterup.min.js')}}" type="63834a1d950dad5106effc44-text/javascript"></script>
		
		<!-- Select2 JS -->
		<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}" type="63834a1d950dad5106effc44-text/javascript"></script>

		<!-- Owl Carousel -->
		<script src="{{asset('assets/js/owl.carousel.min.js')}}" type="63834a1d950dad5106effc44-text/javascript"></script>	

		<!-- Slick Slider -->
		<script src="{{asset('assets/plugins/slick/slick.js')}}" type="63834a1d950dad5106effc44-text/javascript"></script>
		
		<!-- Aos -->
		<script src="{{asset('assets/plugins/aos/aos.js')}}" type="63834a1d950dad5106effc44-text/javascript"></script>
		
		<!-- Custom JS -->
		<script src="{{asset('assets/js/script.js')}}" type="63834a1d950dad5106effc44-text/javascript"></script>
		
	<script src="https://dreamslms.dreamstechnologies.com/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="63834a1d950dad5106effc44-|49" defer></script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"95b47d3f195c8e86","version":"2025.6.2","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}' crossorigin="anonymous"></script>
	<!-- Bootstrap Bundle with Popper.js -->
	<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
	@stack('scripts')

</body>

</html>