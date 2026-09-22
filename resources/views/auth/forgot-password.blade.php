<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - DinePay</title>
    
    <link rel="shortcut icon" href="{{ asset('assets/admin/static/images/logo/favicon.svg') }}" type="image/svg+xml">
    <link rel="shortcut icon" href="{{ asset('assets/admin/static/images/logo/favicon.png') }}" type="image/png">

    <link rel="stylesheet" crossorigin href="{{ asset('assets/admin/compiled/css/app.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/admin/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/admin/compiled/css/auth.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/admin/extensions/bootstrap-icons/font/bootstrap-icons.min.css') }}">
</head>
<body>
    <script src="{{ asset('assets/admin/static/js/components/dark.js') }}"></script>
    
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="mb-5">
                        <a href="{{ url('/') }}" style="display: flex !important; align-items: center !important; flex-direction: row !important; text-decoration: none !important;">
                            <div style="display: block !important; margin-right: 15px !important;">
                                <i class="bi bi-shop text-primary" style="font-size: 2.8rem !important; line-height: 1 !important; margin: 0 !important; padding: 0 !important;"></i>
                            </div>
                            <div style="display: block !important; padding-top: 5px !important;">
                                <span class="text-primary" style="font-size: 2.2rem !important; font-weight: 800 !important; line-height: 1 !important; margin: 0 !important; padding: 0 !important;">DinePay</span>
                            </div>
                        </a>
                    </div>
                    
                    <h1 class="auth-title">Forgot Password</h1>
                    <p class="auth-subtitle mb-5">Enter your email and we will send you a password reset link.</p>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" name="email" class="form-control form-control-xl @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autofocus>
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" type="submit">Send Reset Link</button>
                    </form>
                    
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Remember your password? <a href="{{ route('login') }}" class="font-bold">Log in</a>.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right" class="bg-primary h-100 d-flex align-items-center justify-content-center">
                    <h1 class="text-white">DinePay POS & Cashier System</h1>
                </div>
            </div>
        </div>
    </div>
</body>
</html>