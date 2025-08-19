    @include('admin.layouts.css_links')
    <div class="page error-bg">
        <!-- Start::error-page -->
        <div class="error-page">
            <div class="container">
                <div class="my-auto">
                    <div class="row align-items-center justify-content-center h-100">
                        <div class="col-xl-8 col-lg-5 col-md-6 col-12 text-center">
                            <p class="error-text mb-4 text-fixed-white">404</p>
                            <p class="fs-23 fw-medium mb-2 text-fixed-white">Whoops, this page seems to be missing!</p>
                            <p class="fs-16 text-fixed-white mb-5 op-6">The page you're trying to reach may have been
                                removed, relocated, or doesn't exist.</p>
                            <a href="/login" class="btn btn-warning"><i
                                    class="ri-arrow-left-line align-middle me-1 d-inline-block lh-1"></i>Back To
                                Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
    @endpush
