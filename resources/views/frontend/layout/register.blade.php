@extends('frontend.web_layout.master')

@section('content')

<!-- Full page flex wrapper -->
<div class="d-flex flex-column justify-content-center" style="min-height: 100vh;">

    <div class="container">
        <div class="row">

            <!-- Login Banner (Left) -->
            <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center login-bg">
                <div class="text-center px-4">
                    <div class="mb-4">
                        <img src="{{ asset('frontend/assets/img/auth/auth-1.svg') }}" class="img-fluid" alt="Banner Image">
                    </div>
                    <div class="mentor-course text-white">
                        <h3 class="mb-3">Welcome to <br>XP<span class="text-secondary">Labs</span> Courses.</h3>
                        <p>
                            Platform designed to help organizations, educators, and learners manage,
                            deliver, and track learning and training activities.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Signup Form (Right) -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center login-wrap-bg py-5">
                <div class="w-100" style="max-width: 480px;">
                    <div class="loginbox">

                        <!-- Header -->


                        <h1 class="fs-32 fw-bold mb-4">Sign Up</h1>

                        <!-- Sign Up Form -->
                        <form method="POST" action="{{ route('register.user') }}">
                            @csrf

                            <!-- Full Name -->
                            <div class="mb-3">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-lg" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-control-lg" required>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control form-control-lg" required>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control form-control-lg" required>
                            </div>

                            <!-- Terms Checkbox -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" required>
                                <label class="form-check-label">
                                    I agree with <a href="#" class="text-decoration-underline">Terms of Service</a> and
                                    <a href="#" class="text-decoration-underline">Privacy Policy</a>
                                </label>
                            </div>

                            <!-- Submit Button -->

                            <!-- Sign Up Button that goes to # -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-secondary btn-lg">Sign Up</button>
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

                        <!-- Or Separator -->
                        <div class="text-center text-muted mb-3">
                            <span class="border-bottom w-25 d-inline-block align-middle"></span>
                            <span class="mx-2">OR</span>
                            <span class="border-bottom w-25 d-inline-block align-middle"></span>
                        </div>

                        <!-- Social Login Buttons -->
                        <div class="d-flex justify-content-center mb-4">
                            <a href="#" class="btn btn-outline-secondary me-2 d-flex align-items-center">
                                <img src="{{ asset('frontend/assets/img/icons/google.svg') }}" alt="Google" class="me-2"> Google
                            </a>
                            <a href="#" class="btn btn-outline-secondary d-flex align-items-center">
                                <img src="{{ asset('frontend/assets/img/icons/facebook.svg') }}" alt="Facebook" class="me-2"> Facebook
                            </a>
                        </div>

                        <!-- Link to Login -->
                        <div class="text-center">
                            Already have an account?
                            <a href="{{ route('frontend.layout.login') }}" class="text-decoration-underline">Login</a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection