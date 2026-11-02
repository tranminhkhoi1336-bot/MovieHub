
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - MovieHub</title>

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

        .register-box {
            width: 420px;
            max-width: 92%;
            padding: 35px;
            margin: 24px 0;
            background: #252e40;
            border-radius: 12px;
        }

        h1 {
            text-align: center;
            color: #ff914d;
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 15px;
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
    <div class="register-box">
        <h1>MovieHub</h1>
        <h2>Đăng ký tài khoản</h2>

        <form method="POST"
              action="{{ route('register') }}">
            @csrf

            <label for="name">Họ và tên</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
                maxlength="255"
            >

            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
            >

            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="password">Mật khẩu</label>
            <input
                type="password"
                id="password"
                name="password"
                minlength="8"
                required
            >

            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="password_confirmation">
                Xác nhận mật khẩu
            </label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                minlength="8"
                required
            >

            <button type="submit">
                Đăng ký
            </button>
        </form>

        <div class="links">
            <p>Đã có tài khoản?
                <a href="{{ route('login') }}">
                    Đăng nhập ngay
                </a>
            </p>

            <a href="{{ route('movies.index') }}">
                Quay về trang chủ
            </a>
        </div>
    </div>
</body>
</html>
