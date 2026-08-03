<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Home Improvement</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: #1e293b;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 16px;
            padding: 40px 36px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.25);
        }

        .form-title {
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 6px;
        }

        .form-subtitle {
            font-size: 14px;
            color: #6b7280;
            text-align: center;
            margin-bottom: 28px;
        }

        .field-group {
            margin-bottom: 18px;
        }

        .field-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .input-wrap {
            position: relative;
        }

        .field-input {
            width: 100%;
            padding: 12px 14px;
            font-size: 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.15s;
        }

        .field-input:focus {
            border-color: #1a1a1a;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 13px;
            color: #6b7280;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .toggle-password:hover {
            color: #1a1a1a;
        }

        .forgot-row {
            text-align: right;
            margin-bottom: 20px;
        }

        .forgot-row a {
            font-size: 13px;
            color: #1a1a1a;
            font-weight: 600;
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #111111;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s;
        }

        .btn-submit:hover {
            background: #2a2a2a;
        }

        .signup-row {
            text-align: center;
            margin-top: 18px;
            font-size: 13.5px;
            color: #4b5563;
        }

        .signup-row a {
            color: #111;
            font-weight: 700;
            text-decoration: underline;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            font-size: 13px;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 18px;
        }
    </style>
</head>
<body>

    <div class="auth-card">

        <div class="form-title">Masuk</div>
        <div class="form-subtitle">Selamat Datang</div>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="field-group">
                <label class="field-label" for="email">Email</label>
                <div class="input-wrap">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="field-input"
                        placeholder="Masukkan email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                </div>
            </div>

            <div class="field-group">
    <label class="field-label" for="password">Password</label>

    <div class="input-wrap">

        <input
            type="password"
            id="password"
            name="password"
            class="field-input"
            placeholder="Masukkan password"
            required
        >

        <button
            type="button"
            class="toggle-password"
            onclick="togglePassword()">

            <!-- Mata Terbuka -->
            <svg id="eyeOpen"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                width="20"
                height="20">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5.25 12 5.25c4.477 0 8.268 2.693 9.542 6.75-1.274 4.057-5.065 6.75-9.542 6.75-4.477 0-8.268-2.693-9.542-6.75z"/>

                <circle
                    cx="12"
                    cy="12"
                    r="3"
                    stroke-width="2"/>
            </svg>

            <!-- Mata Tertutup -->
            <svg id="eyeClose"
                style="display:none"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                width="20"
                height="20">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 3l18 18"/>

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M10.58 10.58a2 2 0 102.83 2.83"/>

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9.88 5.09A9.77 9.77 0 0112 4.5c4.48 0 8.27 2.69 9.54 6.75a10.74 10.74 0 01-2.16 3.44M6.23 6.23A10.72 10.72 0 002.46 12c1.27 4.06 5.06 6.75 9.54 6.75a9.7 9.7 0 004.03-.86"/>
            </svg>

        </button>

    </div>
</div>
            <div class="forgot-row">
                <a href="#">Lupa password?</a>
            </div>

            <button type="submit" class="btn-submit">Masuk</button>
        </form>

        <div class="signup-row">
            Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>

    </div>

</body>
</html>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const btn = document.querySelector('.toggle-password');
        if (input.type === 'password') {
            input.type = 'text';
            btn.textContent = 'Sembunyikan';
        } else {
            input.type = 'password';
            btn.textContent = 'Lihat';
        }
    }
</script>