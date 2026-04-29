<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        Log In Sirase
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('template/css/material-dashboard.css') }}" rel="stylesheet" />
</head>

<body class="login-page">

    <div class="login-wrapper">

        <div class="login-card text-center">

            {{-- LOGO --}}
            <div class="mb-3 d-flex justify-content-center">
                <div class="logo-circle-ubaya">
                    <img src="{{ asset('template/img/logoubaya.png') }}" alt="UBAYA">
                </div>
            </div>

            {{-- TITLE --}}
            <h4 class="fw-bold mb-1">SIRASE UBAYA</h4>
            <p class="small opacity-75 mb-4">
                Sistem Rekrutmen & Seleksi Universitas Surabaya
            </p>

            {{-- ALERT SUCCESS --}}
            @if (session('success'))
                <div class="alert alert-success py-2">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ALERT ERROR --}}
            @if (session('error'))
                <div class="alert alert-danger py-2">
                    {{ session('error') }}
                </div>
            @endif

            {{-- FORM --}}
            <form action="{{ route('login.process') }}" method="POST" class="text-start">

                @csrf

                {{-- EMAIL --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"  style="padding:10px; border-radius:10px;" placeholder="nama@email.com"
                        value="{{ old('email') }}" required>
                </div>

                {{-- PASSWORD --}}
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" style="padding:10px; border-radius:10px;" placeholder="••••••••" required>
                </div>

                {{-- BUTTON --}}
                <button type="submit" class="btn btn-ubaya w-100 text-white mt-2">
                    Sign In
                </button>

            </form>

            {{-- FOOTER --}}
            <p class="mt-4 small opacity-50">
                © {{ date('Y') }} Universitas Surabaya
            </p>

        </div>

    </div>
    <script>
        // kalau kamu pakai logout flag
        if (localStorage.getItem('logged_out') === 'true') {
            localStorage.removeItem('logged_out');
            window.location.href = "{{ route('login') }}";
        }
    </script>
</body>
</html>
<!--   Core JS Files   -->
{{-- </body> --}}
