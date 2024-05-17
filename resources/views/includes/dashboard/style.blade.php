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
