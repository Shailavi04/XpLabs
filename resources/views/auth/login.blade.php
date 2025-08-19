{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
<x-guest-layout>
    @include('admin.layouts.css_links')

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="container-lg">
        <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                <div class="my-5 d-flex justify-content-center">
                    <a href="{{ route('login') }}">
                        <img src="{{ asset('admin/assets/images/brand-logos/desktop-dark.png') }}" alt="logo" class="desktop-dark">
                    </a>
                </div>
                <div class="card custom-card my-4 auth-circle">
                    <div class="card-body p-5">
                        <p class="h4 mb-2 fw-semibold">Sign In</p>
                        <p class="mb-4 text-muted fw-normal">Hi, welcome back!</p>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row gy-3">

                                
                                <!-- Email -->
                                <div class="col-xl-12">
                                    <label for="email" class="form-label text-default">Email Address</label>
                                    <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Password -->
                                <div class="col-xl-12 mb-2">
                                    <label for="password" class="form-label text-default d-block">
                                        Password
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="float-end link-danger op-5 fw-medium fs-12">Forget password?</a>
                                        @endif
                                    </label>
                                    <div class="position-relative">
                                        <x-text-input id="password" class="form-control" type="password" name="password" required />
                                        <a href="javascript:void(0);" class="show-password-button text-muted" onclick="createpassword('password',this)">
                                            <i class="ri-eye-off-line align-middle"></i>
                                        </a>
                                    </div>
                                    <div class="mt-2">
                                        <div class="form-check">
                                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                            <label class="form-check-label text-muted fw-normal fs-12" for="remember_me">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Social -->
                            <div class="text-center my-4 authentication-barrier">
                                <span class="text-muted fs-11">Or Join With</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-2 mb-3 flex-wrap">
                                <button type="button" class="btn btn-icon btn-orange-light">
                                    <i class="ri-google-line fs-17 align-middle icon-custom"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-info-light">
                                    <i class="ri-facebook-line fs-17 align-middle icon-custom"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-pink-light">
                                    <i class="ri-twitter-x-line fs-17 align-middle icon-custom"></i>
                                </button>
                            </div>

                            <!-- Submit -->
                            <div class="d-grid mt-4">
                                <x-primary-button class="btn btn-primary w-100">
                                    {{ __('Log in') }}
                                </x-primary-button>
                            </div>
                        </form>

                        <!-- Register -->
                        <div class="text-center">
                            <p class="text-muted mt-3 mb-0">
                                Don't have an account?
                                <a href="{{ route('register') }}" class="text-primary">Sign Up</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endguest-layout