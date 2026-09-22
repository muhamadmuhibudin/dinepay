<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - DinePay</title>
    
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
                    
                    <h1 class="auth-title">Reset Password</h1>
                    <p class="auth-subtitle mb-5">Please enter your new password below.</p>

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" name="email" class="form-control form-control-xl @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" class="form-control form-control-xl @error('password') is-invalid @enderror" placeholder="New Password" required autocomplete="new-password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password_confirmation" class="form-control form-control-xl @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password" required autocomplete="new-password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" type="submit">Reset Password</button>
                    </form>
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