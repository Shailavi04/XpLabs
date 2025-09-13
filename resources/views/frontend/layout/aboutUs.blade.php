@extends('frontend.web_layout.master')

@section('content')


<!-- Breadcrumb -->
<div class="breadcrumb-bar text-center" style="margin-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title mb-2">About Us</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('frontend.layout.index') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">About Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<!-- about -->
<section class="about-section-two pb-0">
    <div class="container">
        @foreach($about_us as $about)
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="p-3 p-sm-4 position-relative">
                    <div class="position-absolute top-0 start-0 z-n1">
                        <img src="{{asset('frontend/assets/img/shapes/shape-1.svg')}}" alt="img">
                    </div>
                    <div class="position-absolute bottom-0 end-0 z-n1">
                        <img src="{{asset('frontend/assets/img/shapes/shape-2.svg')}}" alt="img">
                    </div>
                    <div class="position-absolute bottom-0 start-0 mb-md-5 ms-md-n5">
                        <img src="{{asset('frontend/assets/img/icons/icon-1.svg')}}" alt="img">
                    </div>
                    <!-- <img class="img-fluid img-radius" src="{{asset('frontend/assets/img/about/about-2.svg')}}" alt="img"> -->
                    <img class="img-fluid img-radius" src="{{asset('frontend/'.$about->main_image)}}" alt="img">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ps-0 ps-lg-2 pt-4 pt-lg-0 ps-xl-5">
                    <div class="section-header">
                        <span class="fw-medium text-secondary text-decoration-underline mb-2 d-inline-block">{{ $about->heading }}</span>
                        <h2>{{ $about->sub_heading }}</h2>
                        <p>{{ $about->description }}</p>
                    </div>

                    @foreach ($about->cards as $card)

                    <div class="d-flex align-items-center about-us-banner">
                        <div>
                            <span class="bg-primary-transparent rounded-3 p-2 about-icon d-flex justify-content-center align-items-center">
                                <i class="isax isax-book-1 fs-24"></i>
                            </span>
                        </div>
                        <div class="ps-3">
                            <h6 class="mb-2">{{ $card['icon_text'] }}</h6>
                            <p>{{ $card['icon_description'] }}</p>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
<!-- about -->



<!-- institutions -->
<section class="client-section">

</section>
<!-- institutions -->

<!-- counter -->
<section class="counter-sec section student-course student-course-five">
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

<!-- counter -->
<!-- benefits -->
<div class="benefits-section" style="background-color: black;">
    <div class="container">
        <div class="section-header text-center aos aos-init aos-animate" data-aos="fade-up">
            <div class="section-badge text-white">
                Our Benefits
            </div>
            <h2 class="text-light">Turn Knowledge into Impact with XPLabs</h2>
            <p class="text-light">The right program, guided by expert mentors, delivers real-world skills and career-ready knowledge.</p>
        </div>
        <div class="row justify-content-center row-gap-4 aos aos-init aos-animate" data-aos="fade-up">
            <div class="col-md-6 col-lg-4">
                <div class="benefits-item">
                    <div class="benefits-img">
                        <img src="{{asset('frontend/assets/img/icons/benefit-icon-01.svg')}}" alt="img" class="img-fluid">
                    </div>
                    <h5 class=" text-light title">Stay motivated with instructors</h5>
                    <p class="text-light mb-0">Stay motivated with engaging instructors on our platform, guiding you through every course.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="benefits-item">
                    <div class="benefits-img">
                        <img src="{{asset('frontend/assets/img/icons/benefit-icon-02.svg')}}" alt="img" class="img-fluid">
                    </div>
                    <h5 class="text-light title">Get certified on courses</h5>
                    <p class="text-light mb-0">Get certified, master modern tech skills, and level up your career whether you’re starting.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="benefits-item">
                    <div class="benefits-img">
                        <img src="{{asset('frontend/assets/img/icons/benefit-icon-03.svg')}}" alt="img" class="img-fluid">
                    </div>
                    <h5 class="text-light title">Build skills on your way</h5>
                    <p class="text-light mb-0">Build skills your way with hands-on labs and immersive courses, tailored to fit.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- benefits -->

<!-- trusted companies -->
<div class="section lead-companies" style="margin-top: 32px; margin-bottom: 32px;">
    @foreach($hiringCompanies as $companies)
    <div class="container">
        <div class="section-header text-center aos" data-aos="fade-up">
            <h2 class="mb-0">{{ $companies->title }}</h2>
        </div>

        @php
        $images = json_decode($companies->company_images, true);
        @endphp

        @if ($images && is_array($images))
        <div class="lead-group aos" data-aos="fade-up">
            <div class="lead-group-slider owl-carousel owl-theme">
                @foreach ($images as $img)
                <div class="item">
                    <div class="lead-img">
                        <img class="img-fluid" alt="Img" src="{{ asset('/uploads/companies/' . $img) }}">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @endforeach
</div>
<!-- /trusted companies -->



@endsection