<!DOCTYPE html>
<html lang="en">

<head>

    <title>@yield('title') | RECIS</title>
    @include('includes.landing.meta')

    @include('includes.landing.head')



</head>

<body class="  pace-running pace-done">
    <div class="pace  pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99"
            style="transform: translate3d(100%, 0px, 0px);">
            <div class="pace-progress-inner"></div>
        </div>
        <div class="pace-activity"></div>
    </div>
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    @include('includes.landing.navbar')
    @include('includes.landing.header')
    {{-- conten --}}
    @yield('content')

    @include('includes.landing.footer')



    @include('includes.landing.head')



    {{-- models --}}


    <!-- Core scripts -->
    <script src="{{ asset('vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('vendor/js/bootstrap.js') }}"></script>

    <!-- Libs -->
    <script src="{{ asset('vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('vendor/libs/plyr/plyr.js') }}"></script>

    <!-- Page -->
    <script src="{{ asset('js/landing.js') }}"></script>


    <div id="theme-settings" class=""> <a href="javascript:void(0)" class="theme-settings-open-btn"
            tabindex="-1"></a>
        <h5 class="p-4 m-0 line-height-1 font-weight-bolder bg-light theme-settings-header"> SETTINGS <a
                href="javascript:void(0)" class="theme-settings-close-btn font-weight-light px-4 py-2 text-dark"
                tabindex="-1">×</a> </h5>
        <div class="theme-settings-inner pt-4"> <label
                class="m-0 px-4 pb-3 d-flex media align-items-middle theme-settings-rtl">
                <div class="media-body">RTL direction</div>
                <div class="switcher switcher-sm d-block m-0"> <input class="switcher-input" type="checkbox"> <span
                        class="switcher-indicator"> <span class="switcher-yes"></span> <span class="switcher-no"></span>
                    </span> </div>
            </label> <label class="m-0 px-4 pb-3 d-flex media align-items-middle theme-settings-material">
                <div class="media-body">Material style</div>
                <div class="switcher switcher-sm d-block m-0"> <input class="switcher-input" type="checkbox"> <span
                        class="switcher-indicator"> <span class="switcher-yes"></span> <span class="switcher-no"></span>
                    </span> </div>
            </label>
            <div class="theme-settings-layout">
                <hr class="m-0 border-light">
                <h5 class="m-0 px-4 py-3 line-height-1 text-light d-block"> LAYOUT </h5> <label
                    class="m-0 px-4 pb-3 d-block theme-settings-layoutPosition"> <select
                        class="custom-select custom-select-sm d-block w-100" disabled="disabled">
                        <option value="static">Static</option>
                        <option value="static-offcanvas" disabled="disabled">Static offcanvas</option>
                        <option value="fixed">Fixed</option>
                        <option value="fixed-offcanvas" disabled="disabled">Fixed offcanvas</option>
                    </select> </label> <label
                    class="m-0 px-4 pb-3 d-flex media align-items-middle theme-settings-layoutNavbarFixed disabled">
                    <div class="media-body">Fixed navbar</div>
                    <div class="switcher switcher-sm d-block m-0"> <input class="switcher-input" type="checkbox"
                            disabled="disabled"> <span class="switcher-indicator"> <span class="switcher-yes"></span>
                            <span class="switcher-no"></span> </span> </div>
                </label> <label
                    class="m-0 px-4 pb-3 d-flex media align-items-middle theme-settings-layoutFooterFixed disabled">
                    <div class="media-body">Fixed footer</div>
                    <div class="switcher switcher-sm d-block m-0"> <input class="switcher-input" type="checkbox"
                            disabled="disabled"> <span class="switcher-indicator"> <span class="switcher-yes"></span>
                            <span class="switcher-no"></span> </span> </div>
                </label> <label
                    class="m-0 px-4 pb-3 d-flex media align-items-middle theme-settings-layoutReversed disabled">
                    <div class="media-body">Reversed</div>
                    <div class="switcher switcher-sm d-block m-0"> <input class="switcher-input" type="checkbox"
                            disabled="disabled"> <span class="switcher-indicator"> <span class="switcher-yes"></span>
                            <span class="switcher-no"></span> </span> </div>
                </label>
            </div>
            <div class="theme-settings-navbarBg">
                <hr class="m-0 border-light">
                <h5 class="m-0 px-4 py-3 line-height-1 text-light d-block"> NAVBAR BACKGROUND </h5>
                <fieldset class="m-0 px-4 pb-3 d-block clearfix theme-settings-navbarBg-inner" disabled="disabled">
                    <label class="theme-settings-bg-item bg-navbar-theme active"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="navbar-theme" checked="checked"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-primary"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="primary"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-primary-dark"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="primary-dark navbar-dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-primary-darker"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="primary-darker navbar-dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-secondary"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="secondary"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-secondary-dark"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="secondary-dark navbar-dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-secondary-darker"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="secondary-darker navbar-dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-success"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="success"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-success-dark"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="success-dark navbar-dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-success-darker"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="success-darker navbar-dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-info"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="info"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-info-dark"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="info-dark navbar-dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-info-darker"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="info-darker navbar-dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-warning"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="warning"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-warning-dark"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="warning-dark navbar-light"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-warning-darker"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="warning-darker navbar-light"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-danger"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="danger"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-danger-dark"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="danger-dark navbar-dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-danger-darker"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="danger-darker navbar-dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-dark"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-white"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="white"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-light"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="light"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-lighter"> <input type="radio"
                            name="theme-settings-navbarBg-input" value="lighter"> <span
                            class="theme-settings-bg-name"></span> </label>
                </fieldset>
            </div>
            <div class="theme-settings-sidenavBg">
                <hr class="m-0 border-light">
                <h5 class="m-0 px-4 py-3 line-height-1 text-light d-block"> SIDENAV BACKGROUND </h5>
                <fieldset class="m-0 px-4 pb-3 d-block clearfix theme-settings-sidenavBg-inner"><label
                        class="theme-settings-bg-item bg-sidenav-theme active disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="sidenav-theme" checked="checked"
                            disabled="disabled"> <span class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-primary disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="primary" disabled="disabled"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-primary-dark disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="primary-dark sidenav-dark"
                            disabled="disabled"> <span class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-primary-darker disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="primary-darker sidenav-dark"
                            disabled="disabled"> <span class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-secondary disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="secondary" disabled="disabled"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-secondary-dark disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="secondary-dark sidenav-dark"
                            disabled="disabled"> <span class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-secondary-darker disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="secondary-darker sidenav-dark"
                            disabled="disabled"> <span class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-success disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="success" disabled="disabled"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-success-dark disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="success-dark sidenav-dark"
                            disabled="disabled"> <span class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-success-darker disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="success-darker sidenav-dark"
                            disabled="disabled"> <span class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-info disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="info" disabled="disabled"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-info-dark disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="info-dark sidenav-dark" disabled="disabled">
                        <span class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-info-darker disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="info-darker sidenav-dark"
                            disabled="disabled"> <span class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-warning disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="warning" disabled="disabled"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-warning-dark disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="warning-dark sidenav-light"
                            disabled="disabled"> <span class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-warning-darker disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="warning-darker sidenav-light"
                            disabled="disabled"> <span class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-danger disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="danger" disabled="disabled"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-danger-dark disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="danger-dark sidenav-dark"
                            disabled="disabled"> <span class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-danger-darker disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="danger-darker sidenav-dark"
                            disabled="disabled"> <span class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-dark disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="dark" disabled="disabled"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-white disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="white" disabled="disabled"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-light disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="light" disabled="disabled"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-lighter disabled"> <input type="radio"
                            name="theme-settings-sidenavBg-input" value="lighter" disabled="disabled"> <span
                            class="theme-settings-bg-name"></span> </label></fieldset>
            </div>
            <div class="theme-settings-footerBg">
                <hr class="m-0 border-light">
                <h5 class="m-0 px-4 py-3 line-height-1 text-light d-block"> FOOTER BACKGROUND </h5>
                <fieldset class="m-0 px-4 pb-3 d-block clearfix theme-settings-footerBg-inner" disabled="disabled">
                    <label class="theme-settings-bg-item bg-footer-theme active"> <input type="radio"
                            name="theme-settings-footerBg-input" value="footer-theme" checked="checked"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-primary"> <input type="radio"
                            name="theme-settings-footerBg-input" value="primary"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-primary-dark"> <input type="radio"
                            name="theme-settings-footerBg-input" value="primary-dark footer-dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-primary-darker"> <input type="radio"
                            name="theme-settings-footerBg-input" value="primary-darker footer-dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-secondary"> <input type="radio"
                            name="theme-settings-footerBg-input" value="secondary"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-secondary-dark"> <input type="radio"
                            name="theme-settings-footerBg-input" value="secondary-dark footer-dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-secondary-darker"> <input type="radio"
                            name="theme-settings-footerBg-input" value="secondary-darker footer-dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-success"> <input type="radio"
                            name="theme-settings-footerBg-input" value="success"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-success-dark"> <input type="radio"
                            name="theme-settings-footerBg-input" value="success-dark footer-dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-success-darker"> <input type="radio"
                            name="theme-settings-footerBg-input" value="success-darker footer-dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-info"> <input type="radio"
                            name="theme-settings-footerBg-input" value="info"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-info-dark"> <input type="radio"
                            name="theme-settings-footerBg-input" value="info-dark footer-dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-info-darker"> <input type="radio"
                            name="theme-settings-footerBg-input" value="info-darker footer-dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-warning"> <input type="radio"
                            name="theme-settings-footerBg-input" value="warning"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-warning-dark"> <input type="radio"
                            name="theme-settings-footerBg-input" value="warning-dark footer-light"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-warning-darker"> <input type="radio"
                            name="theme-settings-footerBg-input" value="warning-darker footer-light"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-danger"> <input type="radio"
                            name="theme-settings-footerBg-input" value="danger"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-danger-dark"> <input type="radio"
                            name="theme-settings-footerBg-input" value="danger-dark footer-dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-danger-darker"> <input type="radio"
                            name="theme-settings-footerBg-input" value="danger-darker footer-dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-dark"> <input type="radio"
                            name="theme-settings-footerBg-input" value="dark"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-white"> <input type="radio"
                            name="theme-settings-footerBg-input" value="white"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-light"> <input type="radio"
                            name="theme-settings-footerBg-input" value="light"> <span
                            class="theme-settings-bg-name"></span> </label><label
                        class="theme-settings-bg-item bg-lighter"> <input type="radio"
                            name="theme-settings-footerBg-input" value="lighter"> <span
                            class="theme-settings-bg-name"></span> </label>
                </fieldset>
            </div>
            <div class="theme-settings-themes">
                <hr class="m-0 border-light">
                <h5 class="m-0 px-4 py-3 line-height-1 text-light d-block"> THEME </h5>
                <div class="theme-settings-themes-inner"><label
                        class="theme-settings-theme-item custom-controls-stacked"> <input type="radio"
                            name="theme-settings-current-theme" value="theme-air"> <span class="d-block mr-auto">
                            <span class="theme-settings-theme-checkmark"></span> &nbsp;&nbsp; <span
                                class="theme-settings-theme-name">Air</span> </span> <span
                            class="theme-settings-theme-colors d-flex">
                            <span style="background: #3c97fe"></span>
                            <span style="background: #f8f8f8"></span>
                            <span style="background: #f8f8f8"></span>
                        </span> </label><label class="theme-settings-theme-item custom-controls-stacked"> <input
                            type="radio" name="theme-settings-current-theme" value="theme-corporate"
                            checked="checked"> <span class="d-block mr-auto"> <span
                                class="theme-settings-theme-checkmark"></span> &nbsp;&nbsp; <span
                                class="theme-settings-theme-name">Corporate</span> </span> <span
                            class="theme-settings-theme-colors d-flex">
                            <span style="background: #26B4FF"></span>
                            <span style="background: #fff"></span>
                            <span style="background: #2e323a"></span>
                        </span> </label><label class="theme-settings-theme-item custom-controls-stacked"> <input
                            type="radio" name="theme-settings-current-theme" value="theme-cotton"> <span
                            class="d-block mr-auto"> <span class="theme-settings-theme-checkmark"></span>
                            &nbsp;&nbsp; <span class="theme-settings-theme-name">Сotton</span> </span> <span
                            class="theme-settings-theme-colors d-flex">
                            <span style="background: #e84c64"></span>
                            <span style="background: #ffffff"></span>
                            <span style="background: #ffffff"></span>
                        </span> </label><label class="theme-settings-theme-item custom-controls-stacked"> <input
                            type="radio" name="theme-settings-current-theme" value="theme-gradient"> <span
                            class="d-block mr-auto"> <span class="theme-settings-theme-checkmark"></span>
                            &nbsp;&nbsp; <span class="theme-settings-theme-name">Gradient</span> </span> <span
                            class="theme-settings-theme-colors d-flex">
                            <span style="background: #775cdc"></span>
                            <span style="background: #ffffff"></span>
                            <span style="background: linear-gradient(to top, #4e54c8, #8c55e4)"></span>
                        </span> </label><label class="theme-settings-theme-item custom-controls-stacked"> <input
                            type="radio" name="theme-settings-current-theme" value="theme-paper"> <span
                            class="d-block mr-auto"> <span class="theme-settings-theme-checkmark"></span>
                            &nbsp;&nbsp; <span class="theme-settings-theme-name">Paper</span> </span> <span
                            class="theme-settings-theme-colors d-flex">
                            <span style="background: #17b3a3"></span>
                            <span style="background: #ffffff"></span>
                            <span style="background: #ffffff"></span>
                        </span> </label><label class="theme-settings-theme-item custom-controls-stacked"> <input
                            type="radio" name="theme-settings-current-theme" value="theme-shadow"> <span
                            class="d-block mr-auto"> <span class="theme-settings-theme-checkmark"></span>
                            &nbsp;&nbsp; <span class="theme-settings-theme-name">Shadow</span> </span> <span
                            class="theme-settings-theme-colors d-flex">
                            <span style="background: #7b83ff"></span>
                            <span style="background: #f8f8f8"></span>
                            <span style="background: #ececf9"></span>
                        </span> </label><label class="theme-settings-theme-item custom-controls-stacked"> <input
                            type="radio" name="theme-settings-current-theme" value="theme-soft"> <span
                            class="d-block mr-auto"> <span class="theme-settings-theme-checkmark"></span>
                            &nbsp;&nbsp; <span class="theme-settings-theme-name">Soft</span> </span> <span
                            class="theme-settings-theme-colors d-flex">
                            <span style="background: #1cbb84"></span>
                            <span style="background: #39517b"></span>
                            <span style="background: #ffffff"></span>
                        </span> </label><label class="theme-settings-theme-item custom-controls-stacked"> <input
                            type="radio" name="theme-settings-current-theme" value="theme-sunrise"> <span
                            class="d-block mr-auto"> <span class="theme-settings-theme-checkmark"></span>
                            &nbsp;&nbsp; <span class="theme-settings-theme-name">Sunrise</span> </span> <span
                            class="theme-settings-theme-colors d-flex">
                            <span style="background: #fc5a5c"></span>
                            <span style="background: #222222"></span>
                            <span style="background: #ffffff"></span>
                        </span> </label><label class="theme-settings-theme-item custom-controls-stacked"> <input
                            type="radio" name="theme-settings-current-theme" value="theme-twitlight"> <span
                            class="d-block mr-auto"> <span class="theme-settings-theme-checkmark"></span>
                            &nbsp;&nbsp; <span class="theme-settings-theme-name">Twitlight</span> </span> <span
                            class="theme-settings-theme-colors d-flex">
                            <span style="background: #4c84ff"></span>
                            <span style="background: #343c44"></span>
                            <span style="background: #3f4853"></span>
                        </span> </label><label class="theme-settings-theme-item custom-controls-stacked"> <input
                            type="radio" name="theme-settings-current-theme" value="theme-vibrant"> <span
                            class="d-block mr-auto"> <span class="theme-settings-theme-checkmark"></span>
                            &nbsp;&nbsp; <span class="theme-settings-theme-name">Vibrant</span> </span> <span
                            class="theme-settings-theme-colors d-flex">
                            <span style="background: #fc5a5c"></span>
                            <span style="background: #f8f8f8"></span>
                            <span style="background: #222222"></span>
                        </span> </label></div>
            </div>
        </div>
    </div>


</body>

</html>
