<!DOCTYPE html>
<html>
<head>
    <title>User Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 400px;">
    <div class="card shadow p-4">
        <h4 class="text-center">User Register</h4>

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf

            <div class="mt-3">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mt-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mt-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mt-3">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100 mt-3">Daftar</button>

            <p class="text-center mt-3">
                Sudah punya akun?
                <a href="{{ route('login') }}">Login disini</a>
            </p>
        </form>
    </div>
</div>

</body>
</html>
