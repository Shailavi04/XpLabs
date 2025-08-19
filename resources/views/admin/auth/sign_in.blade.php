@extends('admin.layouts.app')
@section('content')


        <div class="container-lg">
            <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                    <div class="my-5 d-flex justify-content-center"> 
                        <a href="index.html"> 
                            <img src="../assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark"> 
                        </a> 
                    </div>
                    <div class="card custom-card my-4 auth-circle">
                        <div class="card-body p-5">
                            <p class="h4 mb-2 fw-semibold">Sign In</p>
                            <p class="mb-4 text-muted fw-normal">Hi Arjun Arora, welcome back!</p>
                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <label for="signin-username" class="form-label text-default">User Name</label>
                                    <input type="text" class="form-control" id="signin-username" placeholder="user name">
                                </div>
                                <div class="col-xl-12 mb-2">
                                    <label for="signin-password" class="form-label text-default d-block">Password<a href="reset-password-basic.html" class="float-end  link-danger op-5 fw-medium fs-12">Forget password ?</a></label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="signin-password" placeholder="password">
                                        <a href="javascript:void(0);" class="show-password-button text-muted" onclick="createpassword('signin-password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></a>
                                    </div>
                                    <div class="mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                            <label class="form-check-label text-muted fw-normal fs-12" for="defaultCheck1">
                                                Remember password ?
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center my-4 authentication-barrier">
                                <span class="text-muted fs-11">Or Join With</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-2 mb-3 flex-wrap">
                                <button class="btn btn-icon btn-orange-light">
                                    <i class="ri-google-line fs-17 align-middle icon-custom"></i>
                                </button>
                                <button class="btn btn-icon btn-info-light">
                                    <i class="ri-facebook-line fs-17 align-middle icon-custom"></i>
                                </button>
                                <button class="btn btn-icon btn-pink-light">
                                    <i class="ri-twitter-x-line fs-17 align-middle icon-custom"></i>
                                </button>
                            </div>
                            <div class="d-grid mt-4">
                                <a href="index.html" class="btn btn-primary">Sign In</a>
                            </div>
                            <div class="text-center">
                                <p class="text-muted mt-3 mb-0">Dont have an account? <a href="sign-up-basic.html" class="text-primary">Sign Up</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Bootstrap JS -->
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Show Password JS -->
        <script src="../assets/js/show-password.js"></script>

@endsection