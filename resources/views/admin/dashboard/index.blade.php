@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- Start::page-header -->
        <div class="d-flex align-items-center justify-content-between my-3 page-header-breadcrumb flex-wrap gap-2">
            <div>
                <p class="fw-medium fs-18 mb-0">{{ auth()->user()->username ?? '' }}</p>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <div class="d-flex gap-2">
                </div>
            </div>
        </div>
        <!-- End::page-header -->

        <!-- Start:: row-1 -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Dashboard</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Overview</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row g-3">
            @php
                $user = auth()->user();
            @endphp

            <div class="row g-3">

                @if ($user->role_id == 1)
                    <div class="col-xxl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card custom-card">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <p class="fw-medium mb-2">Total Students</p>
                                        <h5 class="fw-semibold mb-3">{{ $students ?? 0 }}</h5>
                                    </div>
                                    <div class="main-card-icon primary">
                                        <div
                                            class="avatar avatar-lg bg-primary border border-primary border-opacity-10 svg-primary d-flex align-items-center justify-content-center">
                                            <!-- Student / User Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="white" viewBox="0 0 16 16" style="background-color:white;">
                                                <path
                                                    d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card custom-card">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <p class="fw-medium mb-2">Instructors</p>
                                        <h5 class="fw-semibold mb-3">{{ $instructors ?? 0 }}</h5>
                                    </div>
                                    <div class="main-card-icon success">
                                        <div
                                            class="avatar avatar-lg bg-success border border-success border-opacity-10 svg-success d-flex align-items-center justify-content-center">
                                            <!-- Instructor / Teacher Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="white" viewBox="0 0 16 16" style="background-color:white;">
                                                <path
                                                    d="M8 0a5 5 0 1 0 0 10A5 5 0 0 0 8 0zm3 12c0-1-3-1.5-3-1.5S5 11 5 12v1h6v-1z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Batches --}}
                    <div class="col-xxl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card custom-card">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <p class="fw-medium mb-2">Batches</p>
                                        <h5 class="fw-semibold mb-3">{{ $batches ?? 0 }}</h5>
                                    </div>
                                    <div class="main-card-icon info">
                                        <div
                                            class="avatar avatar-lg bg-info border border-info border-opacity-10 svg-info d-flex align-items-center justify-content-center">
                                            <!-- Clipboard / Batch Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="white" viewBox="0 0 16 16" style="background-color:white;">
                                                <path
                                                    d="M10 1.5H6a.5.5 0 0 0-.5.5v1H5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-.5v-1a.5.5 0 0 0-.5-.5zM6 2h4v1H6V2z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Courses --}}
                    <div class="col-xxl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card custom-card">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <p class="fw-medium mb-2">Courses</p>
                                        <h5 class="fw-semibold mb-3">{{ $courses ?? 0 }}</h5>
                                    </div>
                                    <div class="main-card-icon danger">
                                        <div
                                            class="avatar avatar-lg bg-danger border border-danger border-opacity-10 svg-danger d-flex align-items-center justify-content-center">
                                            <!-- Book / Course Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="white" viewBox="0 0 16 16" style="background-color:white;">
                                                <path
                                                    d="M1 2.828c.885-.37 2.154-.828 4-.828s3.115.458 4 .828V14c-.885-.37-2.154-.828-4-.828s-3.115.458-4 .828V2.828zM9 1v13.172c.885-.37 2.154-.828 4-.828s3.115.458 4 .828V1c-1.885-.37-3.154-.828-5-.828S10.885.63 9 1z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
              
            @elseif($user->role_id == 2)
                {{-- Center Staff --}}
                {{-- Students --}}
                <div class="col-xxl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card custom-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <p class="fw-medium mb-2">Students</p>
                                    <h5 class="fw-semibold mb-3">{{ $students ?? 0 }}</h5>
                                </div>
                                <div class="main-card-icon primary">
                                    <div
                                        class="avatar avatar-lg bg-primary border border-primary border-opacity-10 svg-primary d-flex align-items-center justify-content-center">
                                        <!-- User / Student Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white"
                                            viewBox="0 0 16 16" style="background-color:white;">
                                            <path
                                                d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Batches --}}
                <div class="col-xxl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card custom-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <p class="fw-medium mb-2">Batches</p>
                                    <h5 class="fw-semibold mb-3">{{ $batches ?? 0 }}</h5>
                                </div>
                                <div class="main-card-icon info">
                                    <div
                                        class="avatar avatar-lg bg-info border border-info border-opacity-10 svg-info d-flex align-items-center justify-content-center">
                                        <!-- Clipboard / Batch Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white"
                                            viewBox="0 0 16 16" style="background-color:white;">
                                            <path
                                                d="M10 1.5H6a.5.5 0 0 0-.5.5v1H5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-.5v-1a.5.5 0 0 0-.5-.5zM6 2h4v1H6V2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Courses --}}
                <div class="col-xxl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card custom-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <p class="fw-medium mb-2">Courses</p>
                                    <h5 class="fw-semibold mb-3">{{ $courses ?? 0 }}</h5>
                                </div>
                                <div class="main-card-icon danger">
                                    <div
                                        class="avatar avatar-lg bg-danger border border-danger border-opacity-10 svg-danger d-flex align-items-center justify-content-center">
                                        <!-- Book / Course Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            fill="white" viewBox="0 0 16 16" style="background-color:white;">
                                            <path
                                                d="M1 2.828c.885-.37 2.154-.828 4-.828s3.115.458 4 .828V14c-.885-.37-2.154-.828-4-.828s-3.115.458-4 .828V2.828zM9 1v13.172c.885-.37 2.154-.828 4-.828s3.115.458 4 .828V1c-1.885-.37-3.154-.828-5-.828S10.885.63 9 1z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($user->role_id == 3)
                {{-- Instructor --}}
                {{-- Repeat same Admin-style cards for Students, Batches, Courses --}}
                <div class="col-xxl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card custom-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <p class="fw-medium mb-2">Students</p>
                                    <h5 class="fw-semibold mb-3">{{ $students ?? 0 }}</h5>
                                </div>
                                <div class="main-card-icon primary">
                                    <div
                                        class="avatar avatar-lg bg-primary border border-primary border-opacity-10 svg-primary">
                                        {{-- SVG Icon --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Batches --}}
                <div class="col-xxl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card custom-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <p class="fw-medium mb-2">Batches</p>
                                    <h5 class="fw-semibold mb-3">{{ $batches ?? 0 }}</h5>
                                </div>
                                <div class="main-card-icon info">
                                    <div class="avatar avatar-lg bg-info border border-info border-opacity-10 svg-info">
                                        {{-- SVG Icon --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Courses --}}
                <div class="col-xxl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card custom-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <p class="fw-medium mb-2">Courses</p>
                                    <h5 class="fw-semibold mb-3">{{ $courses ?? 0 }}</h5>
                                </div>
                                <div class="main-card-icon danger">
                                    <div
                                        class="avatar avatar-lg bg-danger border border-danger border-opacity-10 svg-danger d-flex align-items-center justify-content-center">
                                        <!-- Book SVG Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            fill="white" viewBox="0 0 16 16" style="background-color:white;">
                                            <path
                                                d="M1 2.828c.885-.37 2.154-.828 4-.828s3.115.458 4 .828V14c-.885-.37-2.154-.828-4-.828s-3.115.458-4 .828V2.828zM9 1v13.172c.885-.37 2.154-.828 4-.828s3.115.458 4 .828V1c-1.885-.37-3.154-.828-5-.828S10.885.63 9 1z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($user->role_id == 4)
                {{-- Courses --}}
                <div class="col-xxl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card custom-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <p class="fw-medium mb-2">Courses</p>
                                    <h5 class="fw-semibold mb-3">{{ $courses ?? 0 }}</h5>
                                </div>
                                <div class="main-card-icon primary">
                                    <div
                                        class="avatar avatar-lg bg-primary border border-primary border-opacity-10 svg-primary text-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="currentColor" viewBox="0 0 24 24" style="background-color:white;">
                                            <path d="M4 6h16v2H4V6zm0 5h16v2H4v-2zm0 5h10v2H4v-2z" />
                                        </svg>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Assignments --}}
                <div class="col-xxl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card custom-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <p class="fw-medium mb-2">Assignments</p>
                                    <h5 class="fw-semibold mb-3">{{ $assignments ?? 0 }}</h5>
                                </div>
                                <div class="main-card-icon warning">
                                    <div
                                        class="avatar avatar-lg bg-warning border border-warning border-opacity-10 svg-warning">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" style="background-color:white;">
                                            <path
                                                d="M3 3h18v18H3V3zm2 2v14h14V5H5zm2 2h10v2H7V7zm0 4h10v2H7v-2zm0 4h6v2H7v-2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submitted --}}
                <div class="col-xxl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card custom-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <p class="fw-medium mb-2">Submitted</p>
                                    <h5 class="fw-semibold mb-3">{{ $assignments ?? 0 }}</h5>
                                </div>
                                <div class="main-card-icon success">
                                    <div
                                        class="avatar avatar-lg bg-success border border-success border-opacity-10 svg-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="" viewBox="0 0 24 24" style="background-color:white;">
                                            <path d="M9 16.17l-3.88-3.88L4.71 13.7 9 18l12-12-1.41-1.42z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quizzes --}}
                <div class="col-xxl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card custom-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <p class="fw-medium mb-2">Quizzes</p>
                                    <h5 class="fw-semibold mb-3">{{ $quizzes ?? 0 }}</h5>
                                </div>
                                <div class="main-card-icon info">
                                    <div class="avatar avatar-lg bg-info border border-info border-opacity-10 svg-info">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="#fff" viewBox="0 0 24 24" style="background-color:white;">
                                            <path
                                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                                        </svg>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quizzes --}}
                @endif
            </div>



        </div>
    @endsection
