<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f0f4ff;
        font-family: "Poppins", sans-serif;
        height: 100vh;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center; /* vertical centering */
    }

    .login-card {
        background-color: #ffffff;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 400px;
        text-align: center;
    }

    .login-card h3 {
        color: #1e3a8a;
        margin-bottom: 30px;
        font-weight: 600;
    }

    .login-card input {
        height: 45px;
        border-radius: 10px;
        border: 1px solid #cfd6fc;
        padding: 0 15px;
        margin-bottom: 20px;
        width: 100%;
    }

    .login-card button {
        width: 100%;
        height: 45px;
        background-color: #3b82f6;
        border: none;
        border-radius: 10px;
        color: #fff;
        font-weight: 500;
        transition: 0.3s;
    }

    .login-card button:hover {
        background-color: #2563eb;
    }

    .login-card small {
        display: block;
        margin-top: 15px;
        color: #6b7280;
    }
</style>
</head>
<body>

<div class="login-card">
    <h3>Login</h3>

    @if (session('eror'))
        <div class="alert alert-danger">
            {{ session('eror') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <small>&copy; Azizah XII RPL 2</small>
</div>

</body>
</html>
