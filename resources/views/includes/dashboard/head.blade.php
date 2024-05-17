<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
<meta name="description" content="">
<meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<link rel="icon" type="image/x-icon" href="{{ url('favicon.ico') }}">


<link href="{{ url('https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900') }}"
    rel="stylesheet">

{{-- CSRF Token --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Icon fonts -->
<link rel="stylesheet" href="{{ asset('vendor/fonts/fontawesome.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/fonts/ionicons.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/fonts/linearicons.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/fonts/open-iconic.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/fonts/pe-icon-7-stroke.css') }}">

<!-- Core stylesheets -->
<link rel="stylesheet" href="{{ asset('vendor/css/rtl/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/css/rtl/appwork.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/css/rtl/theme-corporate.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/css/rtl/colors.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/css/rtl/uikit.css') }}">
<link rel="stylesheet" href="{{ asset('css/demo.css') }}">

<script src="{{ asset('vendor/js/material-ripple.js') }}"></script>
<script src="{{ asset('vendor/js/layout-helpers.js') }}"></script>

<link rel="stylesheet" href="{{ url('https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css') }}"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!--- CDN Jquery --->

<script src="{{ url('https://code.jquery.com/jquery-3.6.0.min.js') }}"></script>

<!--- CDN Jquery bootstrap --->
<link href="{{ url('https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css') }}" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!-- Core scripts-->
<script src="{{ asset('vendor/js/pace.js') }}"></script>

<!-- Libs -->
<link rel="stylesheet" href="{{ asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}">
<link rel="stylesheet"
    href="{{ asset('vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/timepicker/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/minicolors/minicolors.css') }}">
<!-- Theme settings -->
<!-- This file MUST be included after core stylesheets and layout-helpers.js in the <head> section -->
<script src="{{ asset('vendor/js/theme-settings.js') }}"></script>


<link rel="stylesheet" href="{{ asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/datatables/datatables.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/spinkit/spinkit.css') }}">
