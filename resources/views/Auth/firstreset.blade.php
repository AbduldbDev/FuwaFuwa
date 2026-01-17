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
        .form-control.is-invalid {
            border-color: red !important;
            box-shadow: none !important;
            /* remove default Bootstrap shadow */
        }

        /* Also when input is focused */
        .form-control.is-invalid:focus {
            border-color: red !important;
            box-shadow: 0 0 0 0.25rem rgba(255, 0, 0, 0.25) !important;
        }

        /* Error text below input */
        .error-text {
            color: red;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>

<body>
    <div class="login">
        <div class="login-wrapper">
            <div class="logo">
                <img src="{{ asset('assets/logo.png') }}" alt="Fuwa Fuwa" />
            </div>

            <h4 class="login-title">Set New Password</h4>
            <p class="login-subtitle">Create a strong password account.</p>

            <form method="POST" action="{{ route('password.reset.first.post') }}">
                @csrf

                {{-- Password --}}
                <div class="form-group position-relative mt-3">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input type="password" name="password" placeholder="Password"
                        class="form-control @error('password') is-invalid @enderror" required>
                </div>
                @error('password')
                    <p class="error-text">{{ $message }}</p>
                @enderror

                {{-- Password Confirmation --}}
                <div class="form-group position-relative mt-4 mb-4">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input type="password" name="password_confirmation" placeholder="Confirm Password"
                        class="form-control @error('password_confirmation') is-invalid @enderror" required>
                    @error('password_confirmation')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-login w-100">Set Password</button>
            </form>

        </div>
    </div>
</body>

</html>
