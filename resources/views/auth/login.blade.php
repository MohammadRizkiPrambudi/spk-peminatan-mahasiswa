<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPK Peminatan Mahasiswa</title>

    <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logokecil.png') }}" />

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .login-wrapper {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .login-form-side {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            width: 30%;
            background-color: #fff;
        }

        .login-image-side {
            width: 70%;
            height: 100vh;
            background: url('{{ asset('assets/images/image-daftar.png') }}') no-repeat center center;
            background-size: cover;
            background-position: center;
        }

        @media (max-width: 991.98px) {
            .login-image-side {
                display: none;
            }

            .login-form-side {
                width: 100%;
            }
        }
    </style>


</head>

<body>
    <div class="container-fluid login-wrapper">
        <div class="login-form-side">
            <div class="auth-form-light w-100" style="max-width: 400px;">
                <div class="brand-logo text-center mb-4">
                    <h4 class="text-primary">SPK Peminatan Mahasiswa TI</h4>
                </div>
                <h4 class="text-center">Halo, Selamat Datang</h4>
                <h6 class="font-weight-light text-center mb-4">Silahkan login terlebih dahulu.</h6>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <input type="email" name="email"
                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                            placeholder="Email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="invalid-feedback mt-2 d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="password" name="password"
                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                            placeholder="Password" required>
                        @error('password')
                            <span class="invalid-feedback mt-2 d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-check mb-3">
                        <label class="form-check-label text-muted">
                            <input type="checkbox" class="form-check-input" name="remember"> Remember Me
                        </label>
                    </div>

                    <div class="mt-3">
                        <button type="submit"
                            class="btn btn-primary btn-block btn-lg font-weight-medium auth-form-btn">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="login-image-side"></div>
    </div>

    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
</body>

</html>
