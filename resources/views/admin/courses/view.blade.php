@extends('admin.layouts.app')

@section('content')

    <style>
        .accordion-button {
            background-color: #589bff91;
            /* light blue background */
            color: #000000;
            /* Bootstrap primary blue */
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .accordion-button:hover {
            background-color: #c7d9ff;
            /* darker blue on hover */
            color: #084298;
            /* darker text */
        }

        /* When expanded, keep a slightly different background */
        .accordion-button:not(.collapsed) {
            background-color: #b0c8ff;
            color: #04297a;
        }

        .accordion-body ul li {
            background-color: #f8f9fa;
            /* Bootstrap light */
            padding: 6px 10px;
            border-radius: 4px;
            margin-bottom: 6px;
            transition: background-color 0.3s ease;
        }

        .accordion-body ul li:hover {
            background-color: #dbe7ff;
            /* light blue hover */
        }
    </style>

    <div class="container-fluid min-vh-100 py-4">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Course Details</h1>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Course</a></li>
                    <li class="breadcrumb-item active">Course Details</li>
                </ol>
            </div>
        </div>
        <div class="row g-4"> {{-- Existing row --}}
            <div class="col-md-4">
                <div class="card custom-card h-100 d-flex justify-content-center align-items-center">
                    <img src="{{ asset('uploads/courses/' . $course->image) }}" alt="{{ $course->name }}" class="img-fluid"
                        style="max-height: 450px; object-fit: contain;">
                </div>
            </div>

            <div class="col-md-8">
                <div class="card custom-card h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h3 class="fw-bold mt-3 mb-3">{{ $course->name }}</h3>
                        <p class="text-muted mb-4">{!! $course->description !!}</p>

                        <div class="d-flex flex-wrap gap-4 mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-star text-warning fs-5"></i>
                                <div class="d-flex flex-column">
                                    <span class="fs-6 fw-semibold">4.6</span>
                                    <small class="text-muted">average rating</small>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-clock text-primary fs-5"></i>
                                <div class="d-flex flex-column">
                                    <span class="fs-6 fw-semibold">{{ $course->duration }} hours</span>
                                    <small class="text-muted">course duration</small>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-users text-success fs-5"></i>
                                <div class="d-flex flex-column">
                                    <span class="fs-6 fw-semibold">{{ $studentcount ?? 0 }}</span>
                                    <small class="text-muted">students enrolled</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2 g-4">
            <div class="col-md-4">
                <div class="card custom-card h-50">
                    <div class="card-header">
                        <h5>Students Enrolled</h5>
                    </div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        @if ($studentcount > 0)
                            <ul class="list-group list-group-flush">
                                @foreach ($student as $s)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ $s->student_name }}</span>
                                        <small class="text-muted">
                                            {{ $s->enrolled_at ?? 'N/A' }}
                                        </small>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No students enrolled yet</p>
                        @endif

                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card custom-card h-100">
                    <div class="card-header">
                        <h5>Course Curriculum</h5>
                    </div>
                    <div class="card-body" style="max-height: 100%; overflow-y: auto;">
                        @if ($curriculumHtml)
                            <ul class="list-group list-group-flush">
                                {!! $curriculumHtml !!}
                            </ul>
                        @else
                            <p class="text-muted">No curriculum available.</p>
                        @endif
                    </div>
                </div>
            </div>


        </div>


    </div>

    </div>
@endsection
