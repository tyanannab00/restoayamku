<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 400px;">
    <div class="card shadow p-4">
        <h4 class="text-center">User Login</h4>

        <form method="POST" action="/login">
            @csrf

            <div class="mt-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="mt-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
            </div>

            <button class="btn btn-success w-100 mt-3">Login</button>

            <p class="text-center mt-3">
                Belum punya akun?
                <a href="{{ route('register') }}">Sign up disini</a>
            </p>
        </form>
    </div>
</div>

</body>
</html>
