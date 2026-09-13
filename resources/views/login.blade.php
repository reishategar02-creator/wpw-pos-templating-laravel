<!doctype html>
<html lang="en">
  <head>
    <title>Login - Gas-Jek</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- Path CSS disesuaikan ke folder public/login_assets -->
    <link rel="stylesheet" href="{{ asset('login_assets/css/style.css') }}">
  </head>
  <body class="img js-fullheight" style="background-image: url('{{ asset('login_assets/images/bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; min-height: 100vh; overflow-x: hidden;">
    <section class="ftco-section d-flex align-items-center justify-content-center py-4" style="min-height: 100vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                   <h2 class="heading-section fw-bold" style="color: #ffffff;">Gas-Jek</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-4 p-md-5" style="background: rgba(0, 0, 0, 0.65); backdrop-filter: blur(8px); border-radius: 16px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);">
                        <h3 class="mb-4 text-center">Masuk ke Sistem Gas-Jek</h3>
                        
                        <!-- Form diarahkan langsung ke halaman admin -->
                        <form action="{{ url('/admin') }}" method="GET" class="signin-form">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input id="password-field" type="password" class="form-control" placeholder="Password">
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn submit px-3 text-white fw-bold" style="background-color: #1acc8d; border-color: #1acc8d;">Sign In</button>
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50">
                                    <label class="checkbox-wrap checkbox-primary">Remember Me
                                        <input type="checkbox" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-50 text-md-right">
                                    <a href="{{ url('/') }}" style="color: #fff">&larr; Beranda</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Path JS disesuaikan ke folder public/login_assets -->
    <script src="{{ asset('login_assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('login_assets/js/popper.js') }}"></script>
    <script src="{{ asset('login_assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('login_assets/js/main.js') }}"></script>
  </body>
</html>