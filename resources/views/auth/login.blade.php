<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SIM Bendahara</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;

            background: url('{{ asset('img/Islamic-Banking.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }

        /* OVERLAY BLUR (BACKGROUND SAJA) */
        .overlay {
            position: absolute;
            inset: 0;
            background: rgba(6, 23, 38, 0.45);
            backdrop-filter: blur(6px);
            z-index: 1;
        }

        /* CARD LOGIN (TAJAM) */
        .card {
            position: relative;
            z-index: 2;
            width: 380px;
            background: #ffffff;
            border-radius: 14px;
            padding: 32px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.35);
        }

        .card h2 {
            text-align: center;
            margin-bottom: 24px;
            color: #0f172a;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 6px;
            color: #334155;
        }

        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            font-size: 14px;
            outline: none;
        }

        .form-group input:focus {
            border-color: #22c55e;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: none;
            background: #22c55e;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #16a34a;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #64748b;
        }
    </style>
</head>
<body>

    <div class="overlay"></div>

    <div class="card">
        <h2>Login SIM Bendahara</h2>

        {{-- ERROR LOGIN --}}
        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required autofocus>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button class="btn-login" type="submit">
                Login
            </button>
        </form>

        <div class="footer">
            © {{ date('Y') }} SIM Bendahara Pondok
        </div>
    </div>

</body>
</html>
