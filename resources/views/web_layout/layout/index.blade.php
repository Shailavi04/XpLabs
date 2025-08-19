@extends('web_layout.master')

@section('content')


<!-- Home Banner -->

@include('layout.home_banner')
<!-- /Home Banner -->

<!-- Vision Section -->
@include('layout.vision_section')
<!-- /Vision Section -->

<!-- About Section -->
@include('layout.about_section')
<!-- /About us -->

<!-- Top Categories -->
@include('layout.top_catagories')
<!-- /Top Categories -->

<!-- Feature Course -->
@include('layout.feature_course')

<!-- /Feature Course -->

@include('layout.professional_section')

@include('layout.yChooseXP')

@include('layout.become_instructor')



@include('layout.certificate')
<!-- Trusted -->
@include('layout.trusted')
<!-- /Trusted -->

<!-- Master Skills -->

<!-- Testimonial -->
@include('layout.testimonial')
<!-- /Testimonial -->
@endsection

