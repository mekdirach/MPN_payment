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
<link rel="stylesheet" href="{{ asset('vendor/css/rtl/bootstrap.css') }}" class="theme-settings-bootstrap-css">
<link rel="stylesheet" href="{{ asset('vendor/css/rtl/appwork.css') }}" class="theme-settings-appwork-css">
<link rel="stylesheet" href="{{ asset('vendor/css/rtl/theme-corporate.css') }}" class="theme-settings-theme-css">
<link rel="stylesheet" href="{{ asset('vendor/css/rtl/colors.css') }}" class="theme-settings-colors-css">
<link rel="stylesheet" href="{{ asset('vendor/css/rtl/uikit.css') }}">
<link rel="stylesheet" href="{{ asset('css/demo.css') }}">

<script src="{{ asset('vendor/js/material-ripple.js') }}"></script>
<script src="{{ asset('vendor/js/layout-helpers.js') }}"></script>

<!-- Theme settings -->
<!-- This file MUST be included after core stylesheets and layout-helpers.js in the <head> section -->
<script src="{{ asset('vendor/js/theme-settings.js') }}"></script>
<script>
    window.themeSettings = new ThemeSettings({
        cssPath: 'vendor/css/rtl/',
        themesPath: 'vendor/css/rtl/'
    });
</script>

<!-- Core scripts -->
<script src="{{ asset('vendor/js/pace.js') }}"></script>
<script src="{{ url('https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js') }}"></script>

<!-- Libs -->
<link rel="stylesheet" href="{{ asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}">
<link rel="stylesheet"
    href="{{ asset('vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/timepicker/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/minicolors/minicolors.css') }}">
