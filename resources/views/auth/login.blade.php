
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - MovieHub</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #1b2230;
            font-family: Arial, sans-serif;
            color: white;
        }

        .login-box {
            width: 400px;
            max-width: 92%;
            padding: 35px;
            background: #252e40;
            border-radius: 12px;
        }

        h1 {
            text-align: center;
            color: #ff914d;
        }

        label {
            display: block;
            margin-top: 18px;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #455064;
            border-radius: 6px;
            background: #151b27;
            color: white;
        }

        button {
            width: 100%;
            padding: 13px;
            margin-top: 25px;
            border: none;
            border-radius: 6px;
            background: #ff914d;
            color: #111;
            font-weight: bold;
            cursor: pointer;
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        a {
            color: #ff914d;
            text-decoration: none;
        }

        .error {
            color: #ff8888;
            font-size: 13px;
            margin-top: 7px;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h1>MovieHub</h1>
        <h2>Đăng nhập</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="email"
            >

            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="password">Mật khẩu</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                autocomplete="current-password"
            >

            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit">Đăng nhập</button>
        </form>

        <div class="links">
            <p>Chưa có tài khoản?
                <a href="{{ route('register') }}">
                    Đăng ký ngay
                </a>
            </p>

            <a href="{{ route('movies.index') }}">
                Quay về trang chủ
            </a>
        </div>
    </div>
</body>
</html>
