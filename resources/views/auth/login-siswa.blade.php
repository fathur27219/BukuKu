<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Siswa - BukuKu</title>
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

    <!-- Left: Brand / Info (tema terang seperti admin panel) -->
    <div class="hidden lg:flex flex-col justify-between p-12 bg-white border-r border-slate-200">
      <div>
        <div class="inline-flex items-center gap-3">
          <div class="h-12 w-12 rounded-2xl bg-slate-900 text-white grid place-items-center font-black">B</div>
          <div>
            <div class="text-xl font-bold tracking-wide text-slate-900">BukuKu</div>
            <div class="text-sm text-slate-500">Portal Siswa</div>
          </div>
        </div>

        <h1 class="mt-12 text-4xl font-bold leading-tight text-slate-900">
          Akses Perpustakaan <br> dengan cepat.
        </h1>
        <p class="mt-4 text-slate-600 max-w-md">
          Login sebagai siswa untuk melihat koleksi buku, status peminjaman, dan riwayat transaksi.
        </p>

        <div class="mt-10 grid grid-cols-2 gap-4 max-w-md">
          <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <div class="text-xs font-semibold text-slate-500 tracking-wide">FITUR</div>
            <div class="mt-1 text-lg font-semibold text-slate-900">Koleksi Buku</div>
            <div class="mt-1 text-sm text-slate-600">Cari & filter cepat</div>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <div class="text-xs font-semibold text-slate-500 tracking-wide">FITUR</div>
            <div class="mt-1 text-lg font-semibold text-slate-900">Peminjaman</div>
            <div class="mt-1 text-sm text-slate-600">Pantau deadline</div>
          </div>
        </div>
      </div>

      <div class="text-xs text-slate-400">
        © {{ date('Y') }} BukuKu — Portal Siswa
      </div>
    </div>

    <!-- Right: Form -->
    <div class="flex items-center justify-center p-6">
      <div class="w-full max-w-md">

        <div class="mb-6">
          <div class="inline-flex items-center gap-2 rounded-full bg-slate-100 text-slate-800 px-4 py-2 text-sm font-semibold border border-slate-200">
            🎓 Login Siswa
          </div>
          <h2 class="mt-4 text-3xl font-bold text-slate-900">Masuk Siswa</h2>
          <p class="mt-1 text-slate-600">Gunakan akun siswa untuk masuk.</p>
        </div>

        @if ($errors->any())
        <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-700">
          {{ $errors->first('login') ?? $errors->first() }}
        </div>
        @endif

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
          <form action="{{ route('login.siswa.process') }}" method="POST" class="space-y-4">
            @csrf

            <div>
              <label class="text-sm font-semibold text-slate-700">Username</label>
              <div class="mt-2 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                  <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                  </svg>
                </div>
                <input name="username" value="{{ old('username') }}"
                  class="w-full rounded-xl border border-slate-200 pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-300"
                  placeholder="username siswa" />
              </div>
            </div>

            <div>
              <label class="text-sm font-semibold text-slate-700">Password</label>
              <div class="mt-2 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                  <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                  </svg>
                </div>
                <input type="password" name="password"
                  class="w-full rounded-xl border border-slate-200 pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-300"
                  placeholder="••••••••" />
              </div>
            </div>

            <button class="w-full rounded-xl bg-slate-900 px-4 py-3 font-semibold text-white hover:bg-slate-800">
              Masuk
            </button>
          </form>

          <div class="mt-6 flex items-center justify-between text-sm">
            <a href="{{ route('login.admin') }}" class="text-slate-700 hover:underline">
              Login sebagai admin →
            </a>

            <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:underline">
              Belum punya akun? Daftar
            </a>
          </div>
        </div>

      </div>
    </div>

  </div>
</body>

</html>