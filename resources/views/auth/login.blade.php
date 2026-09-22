<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DinePay</title>
    
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
                    
                    <h1 class="auth-title">Log in.</h1>
                    <p class="auth-subtitle mb-5">Log in with your email and password.</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" name="email" class="form-control form-control-xl @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autofocus>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" class="form-control form-control-xl @error('password') is-invalid @enderror" placeholder="Password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-gray-600" for="remember">
                                Remember Me
                            </label>
                        </div>

                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" type="submit">Log in</button>
                    </form>
                    
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="font-bold">Sign up</a>.</p>
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