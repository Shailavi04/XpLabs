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

            <!-- Login Form (Right) -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center login-wrap-bg py-5">
                <div class="w-100" style="max-width: 480px;">
                    <div class="loginbox">

                        <!-- Header -->
                        <h1 class="fs-32 fw-bold mb-4">Sign into Your Account</h1>
                        <form method="POST" action="{{ route('login.user') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3 position-relative">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-control-lg" value="{{ old('email') }}" required>
                                @error('email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3 position-relative">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control form-control-lg" required>
                                @error('password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Remember Me + Forgot Password -->
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">Remember Me</label>
                                </div>
                                <a href="#" class="link-2">Forgot Password?</a>
                            </div>

                            <!-- Submit -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-secondary btn-lg">Login</button>
                            </div>
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

                        <!-- Link to Register -->
                        <div class="text-center">
                            Don’t have an account?
                            <a href="{{ route('frontend.layout.register') }}" class="text-decoration-underline">Sign up</a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection