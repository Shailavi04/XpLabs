<div class="col-lg-3 theiaStickySidebar">
    <div class="settings-sidebar">
        <div>
            <h6 class="mb-3">Dashboard</h6>
            <ul class="mb-3 pb-1">
                <li>
                    <a href="{{ route('frontend.dashboards.studentDashboard') }}"
                        class="d-inline-flex align-items-center {{ request()->routeIs('frontend.dashboards.studentDashboard') ? 'active' : '' }}">
                        <i class="isax isax-grid-35 me-2"></i>Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.dashboards.studentProfile') }}"
                        class="d-inline-flex align-items-center {{ request()->routeIs('frontend.dashboards.studentProfile') ? 'active' : '' }}">
                        <i class="fa-solid fa-user me-2"></i>My Profile
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.dashboards.studentCourses') }}"
                        class="d-inline-flex align-items-center {{ request()->routeIs('frontend.dashboards.studentCourses') ? 'active' : '' }}">
                        <i class="isax isax-teacher5 me-2"></i>Enrolled Courses
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.dashboards.studentCertificates') }}"
                        class="d-inline-flex align-items-center {{ request()->routeIs('frontend.dashboards.studentCertificates') ? 'active' : '' }}">
                        <i class="isax isax-note-215 me-2"></i>My Certificates
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.dashboards.studentWishlist') }}"
                        class="d-inline-flex align-items-center {{ request()->routeIs('frontend.dashboards.studentWishlist') ? 'active' : '' }}">
                        <i class="isax isax-heart5 me-2"></i>Wishlist
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.dashboards.studentReviews') }}"
                        class="d-inline-flex align-items-center {{ request()->routeIs('frontend.dashboards.studentReviews') ? 'active' : '' }}">
                        <i class="isax isax-star5 me-2"></i>Reviews
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.dashboards.studentQuiz') }}"
                        class="d-inline-flex align-items-center {{ request()->routeIs('frontend.dashboards.studentQuiz') ? 'active' : '' }}">
                        <i class="isax isax-award5 me-2"></i>My Quiz Attempts
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.dashboards.studentOrder') }}"
                        class="d-inline-flex align-items-center {{ request()->routeIs('frontend.dashboards.studentOrder') ? 'active' : '' }}">
                        <i class="isax isax-shopping-cart5 me-2"></i>Order History
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.dashboards.studentTickets') }}"
                        class="d-inline-flex align-items-center {{ request()->routeIs('frontend.dashboards.studentTickets') ? 'active' : '' }}">
                        <i class="isax isax-ticket5 me-2"></i>Support Tickets
                    </a>
                </li>
            </ul>

            <hr>

            <h6 class="mb-3">Account Settings</h6>
            <ul>
                <li>
                    <a href="#"
                        class="d-inline-flex align-items-center {{ request()->is('settings') ? 'active' : '' }}">
                        <i class="isax isax-setting-25 me-2"></i>Settings
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.layout.register') }}"
                        class="d-inline-flex align-items-center">
                        <i class="isax isax-logout5 me-2"></i>Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
