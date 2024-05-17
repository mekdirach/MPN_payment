<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'NPM')</title>
    @include('includes.dashboard.head')
    <!-- Include SweetAlert2 -->
    <script src="{{ url('https://cdn.jsdelivr.net/npm/sweetalert2@11') }}"></script>

    <link href="{{ url('https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css') }}" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    @yield('head')
</head>

<body>

    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="mymodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mymodalAjax" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>

            </div>
        </div>
    </div>




    <div class="layout-wrapper layout-2">
        <div class="layout-inner">

            @include('includes.dashboard.lay')
            <div class="layout-container">
                @include('includes.dashboard.navbar')
                <div class="layout-content">
                    @yield('content')
                    @include('includes.dashboard.footer')
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-sidenav-toggle"></div>

    </div>


    <script src="{{ url('https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js') }}"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="{{ url('https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js') }}"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    @include('includes.dashboard.script')
    @include('includes.dashboard.bodyscript')
    @yield('scripts')


</body>

</html>
