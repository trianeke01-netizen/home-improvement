<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
</head>
<body>
    <h2>Dashboard Admin</h2>
    <p>Selamat datang, {{ Auth::user()->nama }}!</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>