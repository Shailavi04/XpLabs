        <aside class="app-sidebar sticky" id="sidebar">

            <!-- Start::main-sidebar-header -->
            <div class="main-sidebar-header">
                <a href="index.html" class="header-logo">
                    <img src="{{ asset('admin/assets/images/brand-logos/desktop-dark.png') }}" alt="logo"
                        class="desktop-logo">
                    <img src="{{ asset('admin/assets/images/brand-logos/toggle-dark.png') }}" alt="logo"
                        class="toggle-dark">
                    <img src="{{ asset('admin/assets/images/brand-logos/desktop-dark.png') }}" alt="logo"
                        class="desktop-dark">
                    <img src="{{ asset('admin/assets/images/brand-logos/toggle-logo.png') }}" alt="logo"
                        class="toggle-logo">

                </a>
            </div>
            <!-- End::main-sidebar-header -->

            <!-- Start::main-sidebar -->
            <div class="main-sidebar" id="sidebar-scroll">

                <!-- Start::nav -->
                <nav class="main-menu-container nav nav-pills flex-column sub-open">
                    <div class="slide-left" id="slide-left">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                            viewBox="0 0 24 24">
                            <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                        </svg>
                    </div>
                    <ul class="main-menu">
                        <!-- Start::slide__category -->
                        <li class="slide__category"><span class="category-name">Main</span></li>


                        <li class="slide">
                            <a href="/dashboard" class="side-menu__item">
                                <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em"
                                    height="1em" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                        <path d="m9 22l-.251-3.509a3.259 3.259 0 1 1 6.501 0L15 22" />
                                        <path
                                            d="M2.352 13.214c-.354-2.298-.53-3.446-.096-4.465s1.398-1.715 3.325-3.108L7.021 4.6C9.418 2.867 10.617 2 12.001 2c1.382 0 2.58.867 4.978 2.6l1.44 1.041c1.927 1.393 2.89 2.09 3.325 3.108c.434 1.019.258 2.167-.095 4.464l-.301 1.96c-.5 3.256-.751 4.884-1.919 5.856S16.554 22 13.14 22h-2.28c-3.415 0-5.122 0-6.29-.971c-1.168-.972-1.418-2.6-1.918-5.857z" />
                                    </g>
                                </svg>

                                <span class="side-menu__label">Dashboard</span>
                            </a>
                        </li>
                        <!-- End::slide__category -->

                        {{-- @dd([
                            'role_id' => auth()->user()->role_id,
                            'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
                        ]); --}}
                        @if (auth()->user()->can('view_permission') ||
                                auth()->user()->can('create_permission') ||
                                auth()->user()->can('edit_permission') ||
                                auth()->user()->can('delete_permission'))
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <!-- Quiz Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em"
                                        height="1em" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 2a10 10 0 100 20 10 10 0 000-20zM7 9h2v2H7V9zm0 4h2v2H7v-2zm4-4h6v2h-6V9zm0 4h6v2h-6v-2z" />
                                    </svg>
                                    <span class="side-menu__label">RBAC</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>

                                <ul class="slide-menu child1">
                                    <li class="slide">
                                        <a href="{{ route('modules.index') }}" class="side-menu__item">
                                            Module
                                        </a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('permission.index') }}" class="side-menu__item">
                                            Permission
                                        </a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('role.index') }}" class="side-menu__item">
                                            Role
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif
                        @if (auth()->user()->can('view_users'))
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em"
                                        height="1em" viewBox="0 0 24 24">
                                        <g fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                            <path d="M3 4v16a2 2 0 0 0 2 2h14" />
                                            <path d="M21 4v16a2 2 0 0 0-2-2H7" />
                                            <path d="M3 4h18" />
                                            <path d="M7 12h10" />
                                        </g>
                                    </svg>

                                    <span class="side-menu__label">Users</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>


                                <ul class="slide-menu child1">
                                    <li class="slide">
                                        <a href="{{ route('users.index') }}" class="side-menu__item">
                                            All Users
                                        </a>
                                    </li>

                                    {{-- <li class="slide"> --}}






                                </ul>
                            </li>
                        @endif

                        @if (auth()->user()->can('view_center'))
                            <li class="slide">
                                <a href="{{ route('classes.index') }}" class="side-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em"
                                        height="1em" viewBox="0 0 24 24">
                                        <g fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                            <path d="m9 22l-.251-3.509a3.259 3.259 0 1 1 6.501 0L15 22" />
                                            <path
                                                d="M2.352 13.214c-.354-2.298-.53-3.446-.096-4.465s1.398-1.715 3.325-3.108L7.021 4.6C9.418 2.867 10.617 2 12.001 2c1.382 0 2.58.867 4.978 2.6l1.44 1.041c1.927 1.393 2.89 2.09 3.325 3.108c.434 1.019.258 2.167-.095 4.464l-.301 1.96c-.5 3.256-.751 4.884-1.919 5.856S16.554 22 13.14 22h-2.28c-3.415 0-5.122 0-6.29-.971c-1.168-.972-1.418-2.6-1.918-5.857z" />
                                        </g>
                                    </svg>

                                    <span class="side-menu__label"> Centers
                                    </span>

                                </a>
                            </li>
                        @endif
                        @if (auth()->check() && auth()->user()->can('view_faculty'))
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <i class="ri-group-line side-menu__icon"></i>
                                    <span class="side-menu__label">Faculty</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide">
                                        <a href="{{ route('student_instructors.index') }}" class="side-menu__item">
                                            Instructors
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif





                        @if (auth()->user()->can('view_student'))
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <i class="ri-group-line side-menu__icon"></i>
                                    <span class="side-menu__label">Student</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">

                                    <li class="slide">
                                        <a href="{{ route('student.index') }}" class="side-menu__item">
                                            Students
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if (auth()->user()->can('view_master'))
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em"
                                        height="1em" viewBox="0 0 24 24">
                                        <g fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                            <path d="M3 4v16a2 2 0 0 0 2 2h14" />
                                            <path d="M21 4v16a2 2 0 0 0-2-2H7" />
                                            <path d="M3 4h18" />
                                            <path d="M7 12h10" />
                                        </g>
                                    </svg>

                                    <span class="side-menu__label">Master</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>

                                <ul class="slide-menu child1">
                                    <li class="slide">
                                        <a href="{{ route('categories.index') }}" class="side-menu__item">
                                            Category
                                        </a>
                                    </li>





                                </ul>
                            </li>
                        @endif

                        @if (auth()->user()->can('view_course'))
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <i class="ri-book-line side-menu__icon"></i>
                                    <span class="side-menu__label">Courses </span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide">
                                        <a href="{{ route('course.index') }}" class="side-menu__item">
                                            Courses
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif




                        <!-- End::slide -->
                        @if (auth()->user()->can('view_enrollment'))
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <!-- Icon for Enrollment -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em"
                                        height="1em" viewBox="0 0 24 24">
                                        <!-- example icon paths, replace as needed -->
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1.5" d="M3 12h18M3 6h18M3 18h18" />
                                    </svg>
                                    <span class="side-menu__label">Enrollment</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide">
                                        <a href="{{ route('enrollment.index') }}" class="side-menu__item">Enrollment
                                            List</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('enrollment.lifecycle') }}"
                                            class="side-menu__item">Enrollment
                                            Stages</a>
                                    </li>

                                </ul>
                            </li>
                        @endif

                        @if (auth()->user()->can('view_batch'))
                            <li class="slide">
                                <a href="{{ route('batch.index') }}" class="side-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em"
                                        height="1em" viewBox="0 0 24 24">
                                        <g fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                            <path d="m9 22l-.251-3.509a3.259 3.259 0 1 1 6.501 0L15 22" />
                                            <path
                                                d="M2.352 13.214c-.354-2.298-.53-3.446-.096-4.465s1.398-1.715 3.325-3.108L7.021 4.6C9.418 2.867 10.617 2 12.001 2c1.382 0 2.58.867 4.978 2.6l1.44 1.041c1.927 1.393 2.89 2.09 3.325 3.108c.434 1.019.258 2.167-.095 4.464l-.301 1.96c-.5 3.256-.751 4.884-1.919 5.856S16.554 22 13.14 22h-2.28c-3.415 0-5.122 0-6.29-.971c-1.168-.972-1.418-2.6-1.918-5.857z" />
                                        </g>
                                    </svg>

                                    <span class="side-menu__label">Batch</span>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->can('view_attendance'))
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <!-- Quiz Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em"
                                        height="1em" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 2a10 10 0 100 20 10 10 0 000-20zM7 9h2v2H7V9zm0 4h2v2H7v-2zm4-4h6v2h-6V9zm0 4h6v2h-6v-2z" />
                                    </svg>
                                    <span class="side-menu__label">Attendance</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>

                                <ul class="slide-menu child1">
                                    <li class="slide">
                                        <a href="{{ route('attendance.create') }}" class="side-menu__item">
                                            Mark Attendance
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif

                        @if (auth()->user()->can('view_assignment'))
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <!-- Quiz Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em"
                                        height="1em" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 2a10 10 0 100 20 10 10 0 000-20zM7 9h2v2H7V9zm0 4h2v2H7v-2zm4-4h6v2h-6V9zm0 4h6v2h-6v-2z" />
                                    </svg>
                                    <span class="side-menu__label">Assignment</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>

                                <ul class="slide-menu child1">
                                    <li class="slide">
                                        <a href="{{ route('assignment.index') }}" class="side-menu__item">
                                            Assignment
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif

                        @if (auth()->user()->can('view_exam'))
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <!-- Quiz Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em"
                                        height="1em" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 2a10 10 0 100 20 10 10 0 000-20zM7 9h2v2H7V9zm0 4h2v2H7v-2zm4-4h6v2h-6V9zm0 4h6v2h-6v-2z" />
                                    </svg>
                                    <span class="side-menu__label">Exam</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>

                                <ul class="slide-menu child1">
                                    <li class="slide">
                                        <a href="{{ route('exam_online.index') }}" class="side-menu__item">
                                            Online
                                        </a>
                                        <a href="{{ route('exam_offline.index') }}" class="side-menu__item">
                                            Offline
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif


                        @if (auth()->user()->can('view_payment'))
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <!-- Quiz Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em"
                                        height="1em" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 2a10 10 0 100 20 10 10 0 000-20zM7 9h2v2H7V9zm0 4h2v2H7v-2zm4-4h6v2h-6V9zm0 4h6v2h-6v-2z" />
                                    </svg>
                                    <span class="side-menu__label">Fee Management</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>

                                <ul class="slide-menu child1">


                                    <li class="slide">
                                        <a href="{{ route('payment.index') }}" class="side-menu__item"> Fee
                                            Management</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('bank_account.index') }}" class="side-menu__item">
                                            Bank Account
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif



                        @if (auth()->user()->can('view_quiz'))

                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <!-- Quiz Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em"
                                        height="1em" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 2a10 10 0 100 20 10 10 0 000-20zM7 9h2v2H7V9zm0 4h2v2H7v-2zm4-4h6v2h-6V9zm0 4h6v2h-6v-2z" />
                                    </svg>
                                    <span class="side-menu__label">Quiz</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>

                                <ul class="slide-menu child1">

                                    <li class="slide">
                                        <a href="{{ route('quiz.index') }}" class="side-menu__item">
                                            All Quizzes
                                        </a>
                                    </li>
                                    @if (auth()->user()->can('view_question'))
                                        <li class="slide">
                                            <a href="{{ route('quiz.questions.index') }}" class="side-menu__item">
                                                Questions
                                            </a>
                                        </li>
                                    @endif

                                </ul>
                            </li>
                        @endif



                        @if (auth()->user()->can('create_website_frontend'))
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <!-- Main Icon for Web Pages -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em"
                                        height="1em" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M3 4a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v2H3V4zm0 4h18v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8zm4 3v6h2v-6H7zm4 0v6h6v-6h-6z" />
                                    </svg>


                                    <span class="side-menu__label">Web Pages</span>
                                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                                </a>

                                <ul class="slide-menu child1">
                                    @foreach ($sections as $key)
                                        <li class="slide">
                                            <a href="{{ route('web_pages.frontend.section', $key) }}"
                                                class="side-menu__item">
                                                {{ ucfirst($key) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>



                            </li>

                        @endif



                        <li class="slide">
                            <a href="{{ route('classroom.index') }}" class="side-menu__item">
                                <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em"
                                    height="1em" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                        <path d="m9 22l-.251-3.509a3.259 3.259 0 1 1 6.501 0L15 22" />
                                        <path
                                            d="M2.352 13.214c-.354-2.298-.53-3.446-.096-4.465s1.398-1.715 3.325-3.108L7.021 4.6C9.418 2.867 10.617 2 12.001 2c1.382 0 2.58.867 4.978 2.6l1.44 1.041c1.927 1.393 2.89 2.09 3.325 3.108c.434 1.019.258 2.167-.095 4.464l-.301 1.96c-.5 3.256-.751 4.884-1.919 5.856S16.554 22 13.14 22h-2.28c-3.415 0-5.122 0-6.29-.971c-1.168-.972-1.418-2.6-1.918-5.857z" />
                                    </g>
                                </svg>

                                <span class="side-menu__label"> Classroom
                                </span>

                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('study_material.index') }}" class="side-menu__item">
                                <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em"
                                    height="1em" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                        <path d="m9 22l-.251-3.509a3.259 3.259 0 1 1 6.501 0L15 22" />
                                        <path
                                            d="M2.352 13.214c-.354-2.298-.53-3.446-.096-4.465s1.398-1.715 3.325-3.108L7.021 4.6C9.418 2.867 10.617 2 12.001 2c1.382 0 2.58.867 4.978 2.6l1.44 1.041c1.927 1.393 2.89 2.09 3.325 3.108c.434 1.019.258 2.167-.095 4.464l-.301 1.96c-.5 3.256-.751 4.884-1.919 5.856S16.554 22 13.14 22h-2.28c-3.415 0-5.122 0-6.29-.971c-1.168-.972-1.418-2.6-1.918-5.857z" />
                                    </g>
                                </svg>

                                <span class="side-menu__label"> Study Material
                                </span>

                            </a>
                        </li>

                        <li class="slide">
                            <a href="{{ route('annoucement.index') }}" class="side-menu__item">
                                <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="1em"
                                    height="1em" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                        <path d="m9 22l-.251-3.509a3.259 3.259 0 1 1 6.501 0L15 22" />
                                        <path
                                            d="M2.352 13.214c-.354-2.298-.53-3.446-.096-4.465s1.398-1.715 3.325-3.108L7.021 4.6C9.418 2.867 10.617 2 12.001 2c1.382 0 2.58.867 4.978 2.6l1.44 1.041c1.927 1.393 2.89 2.09 3.325 3.108c.434 1.019.258 2.167-.095 4.464l-.301 1.96c-.5 3.256-.751 4.884-1.919 5.856S16.554 22 13.14 22h-2.28c-3.415 0-5.122 0-6.29-.971c-1.168-.972-1.418-2.6-1.918-5.857z" />
                                    </g>
                                </svg>

                                <span class="side-menu__label"> Annoucement
                                </span>

                            </a>
                        </li>






                    </ul>

                    <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                            width="24" height="24" viewBox="0 0 24 24">
                            <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z">
                            </path>
                        </svg></div>
                </nav>
                <!-- End::nav -->

            </div>
            <!-- End::main-sidebar -->

        </aside>
