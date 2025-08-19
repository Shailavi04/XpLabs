<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-width="full-width" data-menu-styles="light" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>XP Labs</title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords"
        content="bootstrap 5 admin template, html dashboard template, dashboard template bootstrap, admin panel template, admin, admin template, bootstrap admin template, admin dashboard ui, dashboard, admin panel bootstrap, bootstrap admin template, admin dashboard bootstrap, html and css, bootstrap dashboard template, template bootstrap admin">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
    <script>
        (function() {
            if (localStorage.getItem("menodarktheme")) {
                const html = document.documentElement;
                html.setAttribute("data-theme-mode", "dark");
                html.setAttribute("data-menu-styles", "dark");
                html.setAttribute("data-header-styles", "transparent");
            }
        })();
    </script>

    @include('admin.layouts.css_links')

    <!-- jQuery first -->




</head>

<body>

    <div class="page">
        @include('admin.layouts.header')
        @include('admin.layouts.sidebar')
        <div class="main-content app-content">
            @yield('content')

            <div class="offcanvas offcanvas-end" tabindex="-1" id="switcher-canvas"
                aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header border-bottom d-block p-0">
                    <div class="d-flex align-items-center justify-content-between p-3">
                        <h5 class="offcanvas-title text-default" id="offcanvasRightLabel">Switcher</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <nav class="border-top border-block-start-dashed">
                        <div class="nav nav-tabs nav-justified" id="switcher-main-tab" role="tablist">
                            <button class="nav-link active" id="switcher-home-tab" data-bs-toggle="tab"
                                data-bs-target="#switcher-home" type="button" role="tab"
                                aria-controls="switcher-home" aria-selected="true">Theme Styles</button>
                            <button class="nav-link" id="switcher-profile-tab" data-bs-toggle="tab"
                                data-bs-target="#switcher-profile" type="button" role="tab"
                                aria-controls="switcher-profile" aria-selected="false">Theme Colors</button>
                        </div>
                    </nav>
                </div>
                <div class="offcanvas-body">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active border-0" id="switcher-home" role="tabpanel"
                            aria-labelledby="switcher-home-tab" tabindex="0">
                            <div class="">
                                <p class="switcher-style-head">Theme Color Mode:</p>
                                <div class="row switcher-style gx-0">
                                    <div class="col-4">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-light-theme">
                                                Light
                                            </label>
                                            <input class="form-check-input" type="radio" name="theme-style"
                                                id="switcher-light-theme" checked>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-dark-theme">
                                                Dark
                                            </label>
                                            <input class="form-check-input" type="radio" name="theme-style"
                                                id="switcher-dark-theme">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <p class="switcher-style-head">Directions:</p>
                                <div class="row switcher-style gx-0">
                                    <div class="col-4">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-ltr">
                                                LTR
                                            </label>
                                            <input class="form-check-input" type="radio" name="direction"
                                                id="switcher-ltr" checked>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-rtl">
                                                RTL
                                            </label>
                                            <input class="form-check-input" type="radio" name="direction"
                                                id="switcher-rtl">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <p class="switcher-style-head">Navigation Styles:</p>
                                <div class="row switcher-style gx-0">
                                    <div class="col-4">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-vertical">
                                                Vertical
                                            </label>
                                            <input class="form-check-input" type="radio" name="navigation-style"
                                                id="switcher-vertical" checked>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-horizontal">
                                                Horizontal
                                            </label>
                                            <input class="form-check-input" type="radio" name="navigation-style"
                                                id="switcher-horizontal">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="navigation-menu-styles">
                                <p class="switcher-style-head">Vertical & Horizontal Menu Styles:</p>
                                <div class="row switcher-style gx-0 pb-2 gy-2">
                                    <div class="col-4">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-menu-click">
                                                Menu Click
                                            </label>
                                            <input class="form-check-input" type="radio"
                                                name="navigation-menu-styles" id="switcher-menu-click">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-menu-hover">
                                                Menu Hover
                                            </label>
                                            <input class="form-check-input" type="radio"
                                                name="navigation-menu-styles" id="switcher-menu-hover">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-icon-click">
                                                Icon Click
                                            </label>
                                            <input class="form-check-input" type="radio"
                                                name="navigation-menu-styles" id="switcher-icon-click">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-icon-hover">
                                                Icon Hover
                                            </label>
                                            <input class="form-check-input" type="radio"
                                                name="navigation-menu-styles" id="switcher-icon-hover">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sidemenu-layout-styles">
                                <p class="switcher-style-head">Sidemenu Layout Styles:</p>
                                <div class="row switcher-style gx-0 pb-2 gy-2">
                                    <div class="col-sm-6">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-default-menu">
                                                Default Menu
                                            </label>
                                            <input class="form-check-input" type="radio"
                                                name="sidemenu-layout-styles" id="switcher-default-menu" checked>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-closed-menu">
                                                Closed Menu
                                            </label>
                                            <input class="form-check-input" type="radio"
                                                name="sidemenu-layout-styles" id="switcher-closed-menu">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-icontext-menu">
                                                Icon Text
                                            </label>
                                            <input class="form-check-input" type="radio"
                                                name="sidemenu-layout-styles" id="switcher-icontext-menu">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-icon-overlay">
                                                Icon Overlay
                                            </label>
                                            <input class="form-check-input" type="radio"
                                                name="sidemenu-layout-styles" id="switcher-icon-overlay">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-detached">
                                                Detached
                                            </label>
                                            <input class="form-check-input" type="radio"
                                                name="sidemenu-layout-styles" id="switcher-detached">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-double-menu">
                                                Double Menu
                                            </label>
                                            <input class="form-check-input" type="radio"
                                                name="sidemenu-layout-styles" id="switcher-double-menu">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <p class="switcher-style-head">Page Styles:</p>
                                <div class="row switcher-style gx-0">
                                    <div class="col-4">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-regular">
                                                Regular
                                            </label>
                                            <input class="form-check-input" type="radio" name="page-styles"
                                                id="switcher-regular" checked>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-classic">
                                                Classic
                                            </label>
                                            <input class="form-check-input" type="radio" name="page-styles"
                                                id="switcher-classic">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-modern">
                                                Modern
                                            </label>
                                            <input class="form-check-input" type="radio" name="page-styles"
                                                id="switcher-modern">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <p class="switcher-style-head">Layout Width Styles:</p>
                                <div class="row switcher-style gx-0">
                                    <div class="col-4">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-default-width">
                                                Compact
                                            </label>
                                            <input class="form-check-input" type="radio" name="layout-width"
                                                id="switcher-default-width">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-full-width">
                                                Full Width
                                            </label>
                                            <input class="form-check-input" type="radio" name="layout-width"
                                                id="switcher-full-width" checked>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-boxed">
                                                Boxed
                                            </label>
                                            <input class="form-check-input" type="radio" name="layout-width"
                                                id="switcher-boxed">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <p class="switcher-style-head">Menu Positions:</p>
                                <div class="row switcher-style gx-0">
                                    <div class="col-4">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-menu-fixed">
                                                Fixed
                                            </label>
                                            <input class="form-check-input" type="radio" name="menu-positions"
                                                id="switcher-menu-fixed" checked>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-menu-scroll">
                                                Scrollable
                                            </label>
                                            <input class="form-check-input" type="radio" name="menu-positions"
                                                id="switcher-menu-scroll">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <p class="switcher-style-head">Header Positions:</p>
                                <div class="row switcher-style gx-0">
                                    <div class="col-4">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-header-fixed">
                                                Fixed
                                            </label>
                                            <input class="form-check-input" type="radio" name="header-positions"
                                                id="switcher-header-fixed" checked>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-header-scroll">
                                                Scrollable
                                            </label>
                                            <input class="form-check-input" type="radio" name="header-positions"
                                                id="switcher-header-scroll">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <p class="switcher-style-head">Loader:</p>
                                <div class="row switcher-style gx-0">
                                    <div class="col-4">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-loader-enable">
                                                Enable
                                            </label>
                                            <input class="form-check-input" type="radio" name="page-loader"
                                                id="switcher-loader-enable">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check switch-select">
                                            <label class="form-check-label" for="switcher-loader-disable">
                                                Disable
                                            </label>
                                            <input class="form-check-input" type="radio" name="page-loader"
                                                id="switcher-loader-disable" checked>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade border-0" id="switcher-profile" role="tabpanel"
                            aria-labelledby="switcher-profile-tab" tabindex="0">
                            <div>
                                <div class="theme-colors">
                                    <p class="switcher-style-head">Menu Colors:</p>
                                    <div class="d-flex switcher-style pb-2">
                                        <div class="form-check switch-select me-3">
                                            <input class="form-check-input color-input color-white"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Light Menu"
                                                type="radio" name="menu-colors" id="switcher-menu-light" checked>
                                        </div>
                                        <div class="form-check switch-select me-3">
                                            <input class="form-check-input color-input color-dark"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Dark Menu"
                                                type="radio" name="menu-colors" id="switcher-menu-dark">
                                        </div>
                                        <div class="form-check switch-select me-3">
                                            <input class="form-check-input color-input color-primary"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Color Menu"
                                                type="radio" name="menu-colors" id="switcher-menu-primary">
                                        </div>
                                        <div class="form-check switch-select me-3">
                                            <input class="form-check-input color-input color-gradient"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Gradient Menu" type="radio" name="menu-colors"
                                                id="switcher-menu-gradient">
                                        </div>
                                        <div class="form-check switch-select me-3">
                                            <input class="form-check-input color-input color-transparent"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Transparent Menu" type="radio" name="menu-colors"
                                                id="switcher-menu-transparent">
                                        </div>
                                    </div>
                                    <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Menu
                                        dynamically change
                                        from below Theme Primary color picker</div>
                                </div>
                                <div class="theme-colors">
                                    <p class="switcher-style-head">Header Colors:</p>
                                    <div class="d-flex switcher-style pb-2">
                                        <div class="form-check switch-select me-3">
                                            <input class="form-check-input color-input color-white"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Light Header"
                                                type="radio" name="header-colors" id="switcher-header-light"
                                                checked>
                                        </div>
                                        <div class="form-check switch-select me-3">
                                            <input class="form-check-input color-input color-dark"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Dark Header"
                                                type="radio" name="header-colors" id="switcher-header-dark">
                                        </div>
                                        <div class="form-check switch-select me-3">
                                            <input class="form-check-input color-input color-primary"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Color Header"
                                                type="radio" name="header-colors" id="switcher-header-primary">
                                        </div>
                                        <div class="form-check switch-select me-3">
                                            <input class="form-check-input color-input color-gradient"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Gradient Header" type="radio" name="header-colors"
                                                id="switcher-header-gradient">
                                        </div>
                                        <div class="form-check switch-select me-3">
                                            <input class="form-check-input color-input color-transparent"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Transparent Header" type="radio" name="header-colors"
                                                id="switcher-header-transparent">
                                        </div>
                                    </div>
                                    <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Header
                                        dynamically
                                        change from below Theme Primary color picker</div>
                                </div>
                                <div class="theme-colors">
                                    <p class="switcher-style-head">Theme Primary:</p>
                                    <div class="d-flex flex-wrap align-items-center switcher-style">
                                        <div class="form-check switch-select me-3">
                                            <input class="form-check-input color-input color-primary-1" type="radio"
                                                name="theme-primary" id="switcher-primary">
                                        </div>
                                        <div class="form-check switch-select me-3">
                                            <input class="form-check-input color-input color-primary-2" type="radio"
                                                name="theme-primary" id="switcher-primary1">
                                        </div>
                                        <div class="form-check switch-select me-3">
                                            <input class="form-check-input color-input color-primary-3" type="radio"
                                                name="theme-primary" id="switcher-primary2">
                                        </div>
                                        <div class="form-check switch-select me-3">
                                            <input class="form-check-input color-input color-primary-4" type="radio"
                                                name="theme-primary" id="switcher-primary3">
                                        </div>
                                        <div class="form-check switch-select me-3">
                                            <input class="form-check-input color-input color-primary-5" type="radio"
                                                name="theme-primary" id="switcher-primary4">
                                        </div>
                                        <div class="form-check switch-select ps-0 mt-1 color-primary-light">
                                            <div class="theme-container-primary"></div>
                                            <div class="pickr-container-primary"
                                                onchange="updateChartColor(this.value)"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="theme-colors">
                                    <p class="switcher-style-head">Theme Background:</p>
                                    <div class="d-flex flex-wrap align-items-center switcher-style">
                                        <div class="form-check switch-select me-3">
                                            <input class="form-check-input color-input color-bg-1" type="radio"
                                                name="theme-background" id="switcher-background">
                                        </div>
                                        <div class="form-check switch-select me-3">
                                            <input class="form-check-input color-input color-bg-2" type="radio"
                                                name="theme-background" id="switcher-background1">
                                        </div>
                                        <div class="form-check switch-select me-3">
                                            <input class="form-check-input color-input color-bg-3" type="radio"
                                                name="theme-background" id="switcher-background2">
                                        </div>
                                        <div class="form-check switch-select me-3">
                                            <input class="form-check-input color-input color-bg-4" type="radio"
                                                name="theme-background" id="switcher-background3">
                                        </div>
                                        <div class="form-check switch-select me-3">
                                            <input class="form-check-input color-input color-bg-5" type="radio"
                                                name="theme-background" id="switcher-background4">
                                        </div>
                                        <div
                                            class="form-check switch-select ps-0 mt-1 tooltip-static-demo color-bg-transparent">
                                            <div class="theme-container-background"></div>
                                            <div class="pickr-container-background"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="menu-image mb-3">
                                    <p class="switcher-style-head">Menu With Background Image:</p>
                                    <div class="d-flex flex-wrap align-items-center switcher-style">
                                        <div class="form-check switch-select m-2">
                                            <input class="form-check-input bgimage-input bg-img1" type="radio"
                                                name="menu-background" id="switcher-bg-img">
                                        </div>
                                        <div class="form-check switch-select m-2">
                                            <input class="form-check-input bgimage-input bg-img2" type="radio"
                                                name="menu-background" id="switcher-bg-img1">
                                        </div>
                                        <div class="form-check switch-select m-2">
                                            <input class="form-check-input bgimage-input bg-img3" type="radio"
                                                name="menu-background" id="switcher-bg-img2">
                                        </div>
                                        <div class="form-check switch-select m-2">
                                            <input class="form-check-input bgimage-input bg-img4" type="radio"
                                                name="menu-background" id="switcher-bg-img3">
                                        </div>
                                        <div class="form-check switch-select m-2">
                                            <input class="form-check-input bgimage-input bg-img5" type="radio"
                                                name="menu-background" id="switcher-bg-img4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center canvas-footer gap-1">
                            <a href="javascript:void(0);" id="reset-all" class="btn btn-danger flex-fill">Reset</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="scrollToTop">
                <span class="arrow lh-1"><i class="ti ti-caret-up fs-20"></i></span>
            </div>
            <div id="responsive-overlay"></div>



        </div>
    </div>

    @include('admin.layouts.scripts_links')

    <!-- Scroll To Top -->

    <!-- Scroll To Top -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    {{-- <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" /> --}}

    {{-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> --}}

    <!-- DataTables JS + Buttons JS -->
    {{-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <shcript src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="ttps://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
 --}}

 <!-- Datatables Cdn -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.6/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>




    <script>
        @if (session('success'))
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                close: true,
                gravity: "top", // top or bottom
                position: "right", // left, center, right
                backgroundColor: "#4BB543",
            }).showToast();
        @endif

        @if (session('error'))
            Toastify({
                text: "{{ session('error') }}",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#FF6F61",
            }).showToast();
        @endif

        
    </script>

    {{-- @include('admin.layouts.sidebar') --}}


    <div id="loader">
        <img src="{{ asset('admin/assets/images/media/loader.svg') }}" alt="">
    </div>

    @include('admin.layouts.footer')
    @stack('script')
</body>

</html>
