<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 400px;">
    <div class="card shadow p-4">
        <h4 class="text-center">Admin Login</h4>

        <form method="POST" action="/admin/login">
            @csrf

            <div class="mt-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="mt-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
            </div>

            <button class="btn btn-primary w-100 mt-3">Login</button>
        </form>
    </div>
</div>

</body>
</html>
