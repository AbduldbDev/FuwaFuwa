<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fuwa Fuwa: Login</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- FONT AWESOME -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}" />

    <style>
        /* Red border for invalid inputs */
        .is-invalid {
            border: 1px solid red !important;
        }

        .error-text {
            color: red;
            font-size: 0.875rem;
            margin-top: 0;
        }
    </style>
</head>

<body>
    <div class="login">
        <div class="login-wrapper">
            <div class="logo">
                <img src="{{ asset('assets/logo.png') }}" alt="Fuwa Fuwa" />
            </div>

            <h4 class="login-title">Welcome Back</h4>
            <p class="login-subtitle">Sign in to continue to your dashboard</p>

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                {{-- Email --}}
                <div class="form-group position-relative mt-3">
                    <i class="fa-regular fa-envelope input-icon"></i>
                    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email"
                        value="{{ old('email') }}" required placeholder="Email Address">
                </div>
                @error('email')
                    <p class="error-text">{{ $message }}</p>
                @enderror

                {{-- Password --}}
                <div class="form-group position-relative mt-3 mb-3">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password"
                        placeholder="Password" required>
                    @error('password')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input shadow-none" type="checkbox" id="rememberMe" name="remember"
                            {{ old('remember') ? 'checked' : '' }} />
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                </div>

                {{-- System Error (login failed) --}}
                @if ($errors->has('email') && !$errors->hasBag('default'))
                    <p class="error-text">{{ $errors->first('email') }}</p>
                @endif

                <button type="submit" class="btn-login w-100">Login</button>
            </form>
        </div>
    </div>
</body>

</html>
