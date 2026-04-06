<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - BukuKu</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-50 text-slate-800">

    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

        <!-- LEFT PANEL -->
        <div class="hidden lg:flex flex-col justify-between p-12 bg-white border-r border-slate-200">

            <div>

                <div class="inline-flex items-center gap-3">
                    <div class="h-12 w-12 rounded-2xl bg-slate-900 text-white grid place-items-center font-black">
                        B
                    </div>

                    <div>
                        <div class="text-xl font-bold text-slate-900">BukuKu</div>
                        <div class="text-sm text-slate-500">Admin Panel</div>
                    </div>
                </div>


                <h1 class="mt-12 text-4xl font-bold leading-tight text-slate-900">
                    Kelola Sistem <br>
                    Perpustakaan.
                </h1>

                <p class="mt-4 text-slate-600 max-w-md">
                    Login sebagai admin untuk mengelola koleksi buku, anggota,
                    transaksi peminjaman, dan laporan perpustakaan.
                </p>


                <div class="mt-10 grid grid-cols-2 gap-4 max-w-md">

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="text-xs font-semibold text-slate-500 tracking-wide">
                            FITUR
                        </div>

                        <div class="mt-1 text-lg font-semibold text-slate-900">
                            Kelola Buku
                        </div>

                        <div class="mt-1 text-sm text-slate-600">
                            Tambah & edit koleksi
                        </div>
                    </div>


                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="text-xs font-semibold text-slate-500 tracking-wide">
                            FITUR
                        </div>

                        <div class="mt-1 text-lg font-semibold text-slate-900">
                            Transaksi
                        </div>

                        <div class="mt-1 text-sm text-slate-600">
                            Kelola peminjaman
                        </div>
                    </div>

                </div>

            </div>


            <div class="text-xs text-slate-400">
                © {{ date('Y') }} BukuKu — Admin Panel
            </div>

        </div>



        <!-- RIGHT LOGIN FORM -->
        <div class="flex items-center justify-center p-6">

            <div class="w-full max-w-md">


                <div class="mb-6">

                    <div class="inline-flex items-center gap-2 rounded-full bg-slate-100 text-slate-800 px-4 py-2 text-sm font-semibold border border-slate-200">
                        🔑 Login Admin
                    </div>

                    <h2 class="mt-4 text-3xl font-bold text-slate-900">
                        Masuk Admin
                    </h2>

                    <p class="mt-1 text-slate-600">
                        Gunakan akun admin untuk masuk.
                    </p>

                </div>


                @if ($errors->any())
                <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-700">
                    {{ $errors->first('login') ?? $errors->first() }}
                </div>
                @endif



                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                    <form action="{{ route('login.admin.process') }}" method="POST" class="space-y-4">

                        @csrf

                        <div>

                            <label class="text-sm font-semibold text-slate-700">
                                Username
                            </label>

                            <input
                                name="username"
                                value="{{ old('username') }}"
                                class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-300"
                                placeholder="admin">

                        </div>


                        <div>

                            <label class="text-sm font-semibold text-slate-700">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-300"
                                placeholder="••••••••">

                        </div>



                        <button class="w-full rounded-xl bg-slate-900 px-4 py-3 font-semibold text-white hover:bg-slate-800">
                            Masuk
                        </button>


                    </form>



                    <div class="mt-6 flex items-center justify-between text-sm">

                        <a href="{{ route('login.siswa') }}" class="text-slate-700 hover:underline">
                            Login sebagai siswa →
                        </a>

                        <a href="{{ url('/') }}" class="text-slate-500 hover:underline">
                            Kembali
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>