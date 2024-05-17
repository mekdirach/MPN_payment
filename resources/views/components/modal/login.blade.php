<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    @include('components.modal.header')
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- Content -->
    <div class="authentication-wrapper authentication-2 ui-bg-cover ui-bg-overlay-container px-4"
        style="background-image: url('assets/img/bg/32.jpg');">
        <div class="ui-bg-overlay bg-dark opacity-25"></div>
        <div class="authentication-inner py-8">
            <div class="card">
                <div class="p-4 p-sm-6">
                    <!-- Logo -->
                    <div class="d-flex justify-content-center ">
                        <img src="assets/img/bg/bjb.png" class="img">
                    </div> <!-- / Logo -->
                    <!-- Form -->
                    <form method="POST" action="{{ route('login.landing') }}">
                        @csrf

                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" name="email" id="email" required autocomplete="email"
                                autofocus placeholder="Email">
                            @if (session('email-error'))
                                <p class="text-danger">{{ session('email-error') }}</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="form-label d-flex justify-content-between align-items-end">
                                <div>Password</div>
                            </label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                placeholder="Password" autocomplete="current-password">
                            @if (session('password-error'))
                                <p class="text-danger">{{ session('password-error') }}</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="captcha">
                                <span>{!! captcha_img('flat') !!}</span>
                                <button type="button" class="btn btn-danger" class="reload" id="reload">
                                    &#x21bb;
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha"
                                name="captcha">
                            @if ($errors->has('captcha'))
                                <p class="text-danger">{{ $errors->first('captcha') }}</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center m-0">
                                <label class="custom-control custom-checkbox m-0">
                                    <input type="checkbox" class="custom-control-input" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <span class="custom-control-label"> {{ __('Remember Me') }}</span>
                                </label>
                                <button type="submit" class="btn btn-primary">Sign In</button>
                            </div>
                        </div>
                    </form>


                    <!-- / Form -->
                </div>
            </div>
        </div>
    </div>

    @include('components.modal.content')


    <script type="text/javascript">
        $('#reload').click(function() {
            $.ajax({
                type: 'GET',
                url: 'reload-captcha',
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Cek apakah ada data yang tersimpan di local storage
            if (localStorage.getItem('rememberMe') === 'true') {
                // Jika ada, setel nilai checkbox "Remember Me" menjadi dicentang
                document.getElementById('remember').checked = true;

                // Jika ada, isi juga kolom email dan password dari local storage
                document.getElementById('email').value = localStorage.getItem('email') || '';
                document.getElementById('password').value = localStorage.getItem('password') || '';
            }

            // Tangani perubahan pada checkbox "Remember Me"
            document.getElementById('remember').addEventListener('change', function() {
                // Jika dicentang, simpan data di local storage
                if (this.checked) {
                    localStorage.setItem('rememberMe', 'true');
                    localStorage.setItem('email', document.getElementById('email').value);
                    localStorage.setItem('password', document.getElementById('password').value);
                } else {
                    // Jika tidak dicentang, hapus data dari local storage
                    localStorage.removeItem('rememberMe');
                    localStorage.removeItem('email');
                    localStorage.removeItem('password');
                }
            });
        });
    </script>

    <style>
        img {
            width: 50%;
            height: 50%;
        }

        .card {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(24, 28, 33, 0.06);
            border-radius: 1.5rem;
        }
    </style>

</body>

</html>
