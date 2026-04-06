<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-6 rounded shadow w-96">
    <h2 class="text-xl font-bold mb-4 text-center">Register Siswa</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-3">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/register">
        @csrf

        <input type="text" name="nama" placeholder="Nama"
            class="w-full border p-2 mb-3 rounded" required>

        <input type="text" name="username" placeholder="Username"
            class="w-full border p-2 mb-3 rounded" required>

        <input type="password" name="password" placeholder="Password"
            class="w-full border p-2 mb-3 rounded" required>

        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
            class="w-full border p-2 mb-3 rounded" required>

        <button class="w-full bg-blue-500 text-white p-2 rounded">
            Daftar
        </button>
    </form>

    <p class="text-sm text-center mt-3">
        Sudah punya akun?
        <a href="/login-siswa" class="text-blue-500">Login</a>
    </p>
</div>

</body>
</html>