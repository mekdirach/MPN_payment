<nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center container-p-x bg-navbar-theme" id="layout-navbar">

    <!-- Brand demo (see assets/css/demo/demo.css) -->


    <!-- Sidenav toggle (see assets/css/demo/demo.css) -->


    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#layout-navbar-collapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="layout-navbar-collapse">
        <!-- Divider -->
        <hr class="d-lg-none w-100 my-2">


        <div class="navbar-nav align-items-lg-center ml-auto">


            <!-- Divider -->
            <div class="nav-item d-none d-lg-block text-big font-weight-light line-height-1 opacity-25 mr-3 ml-1">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">|</font>
                </font>
            </div>

            <div class="demo-navbar-user nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                    <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                        <img src="{{ asset('assets/img/avatars/logobjb.png') }}" alt=""
                            class="d-block ui-w-30 rounded-circle">
                        <span class="px-1 mr-lg-2 ml-2 ml-lg-0">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">{{ Auth::user()->name }}</font>
                            </font>
                        </span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="javascript:void(0)" class="dropdown-item"><i class="ion ion-ios-person text-lightest"></i>
                        &nbsp; My profile</a>
                    <a href="javascript:void(0)" class="dropdown-item"><i class="ion ion-ios-mail text-lightest"></i>
                        &nbsp; Messages</a>
                    <a href="javascript:void(0)" class="dropdown-item"><i class="ion ion-md-settings text-lightest"></i>
                        &nbsp; Account settings</a>
                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route('member.logout.landing') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ion ion-ios-log-out text-danger"></i>
                        &nbsp; Log Out

                        <form action="{{ route('member.logout.landing') }}" id="logout-form" method="POST"
                            style="display: none;">
                            @csrf
                        </form>

                    </a>

                </div>
            </div>
        </div>
    </div>
</nav>
