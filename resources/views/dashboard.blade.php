<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Admin - BukuKu</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">
  <div class="min-h-screen flex">

    @include('sidebar')

    <!-- Main -->
    <main class="flex-1">
      <!-- Topbar -->
      <header class="sticky top-0 z-10 bg-white/80 backdrop-blur border-b border-slate-200">
        <div class="px-6 md:px-8 py-4 flex items-center justify-between">
          <div>
            <h1 class="text-base md:text-lg font-semibold">Ringkasan Perpustakaan</h1>
            <p class="text-xs md:text-sm text-slate-500">Pantau aktivitas & transaksi terbaru</p>
          </div>

          <div class="flex items-center gap-3">
            <div class="text-right leading-tight">
              <p class="text-sm font-medium text-slate-900">{{ optional(auth()->user())->nama ?? optional(auth()->user())->name ?? 'User' }}</p>
              <p class="text-[11px] text-slate-500 uppercase tracking-wide">{{ optional(auth()->user())->role ?? 'Admin' }}</p>
            </div>
            <img
              class="h-10 w-10 rounded-full ring-2 ring-slate-200"
              src="https://ui-avatars.com/api/?name={{ urlencode(optional(auth()->user())->nama ?? optional(auth()->user())->name ?? 'User') }}&background=e2e8f0&color=0f172a"
              alt="User profile" />
          </div>
        </div>
      </header>

      <div class="px-6 md:px-8 py-8 space-y-6">

        <!-- Welcome card (lebih soft, no gradient) -->
        <section class="rounded-2xl border border-slate-200 bg-white p-6 md:p-7">
          <div class="flex items-start justify-between gap-6">
            <div>
              <h2 class="text-xl md:text-2xl font-semibold">
                Halo, {{ optional(auth()->user())->nama ?? optional(auth()->user())->name ?? 'User' }}
              </h2>
              <p class="mt-1 text-sm text-slate-600">
                Ada <span class="font-semibold text-slate-900">5</span> buku melewati batas pengembalian. Cek sekarang ya.
              </p>

              <div class="mt-4 flex flex-wrap gap-2">
                <a href="/transactions"
                  class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
                  Lihat Transaksi
                </a>
                <a href="/books"
                  class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                  Kelola Buku
                </a>
              </div>
            </div>

            <div class="hidden md:block">
              <div class="h-12 w-12 rounded-2xl bg-slate-100 grid place-items-center text-slate-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
              </div>
            </div>
          </div>
        </section>

        <!-- Stat cards (monochrome, modern) -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-semibold text-slate-500 tracking-wide">TOTAL BUKU</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">1,240</p>
            <p class="mt-1 text-xs text-slate-500">Koleksi tersedia</p>
          </div>

          <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-semibold text-slate-500 tracking-wide">DIPINJAM</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">42</p>
            <p class="mt-1 text-xs text-slate-500">Sedang berjalan</p>
          </div>

          <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-semibold text-slate-500 tracking-wide">MEMBER AKTIF</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">850</p>
            <p class="mt-1 text-xs text-slate-500">Terdaftar aktif</p>
          </div>

          <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-semibold text-slate-500 tracking-wide">TERLAMBAT</p>
            <p class="mt-2 text-2xl font-semibold text-rose-600">5</p>
            <p class="mt-1 text-xs text-slate-500">Perlu ditindak</p>
          </div>
        </section>

        <!-- Table card -->
        <section class="rounded-2xl border border-slate-200 bg-white overflow-hidden">
          <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-base font-semibold">Transaksi Peminjaman Terbaru</h3>
            <a href="/transactions"
              class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
              Lihat Semua
            </a>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left">
              <thead class="bg-slate-50">
                <tr class="text-[11px] uppercase tracking-wide text-slate-500">
                  <th class="px-6 py-3 font-semibold">Peminjam</th>
                  <th class="px-6 py-3 font-semibold">Buku</th>
                  <th class="px-6 py-3 font-semibold">Tanggal Pinjam</th>
                  <th class="px-6 py-3 font-semibold">Status</th>
                </tr>
              </thead>

              <tbody class="divide-y divide-slate-100">
                <tr class="hover:bg-slate-50">
                  <td class="px-6 py-4">
                    <div class="font-medium text-slate-900">Budi Santoso</div>
                    <div class="text-xs text-slate-500">ID: #M001</div>
                  </td>
                  <td class="px-6 py-4 text-sm text-slate-700 font-medium">
                    Belajar Laravel Dasar
                  </td>
                  <td class="px-6 py-4 text-sm text-slate-600">
                    05 Feb 2026
                  </td>
                  <td class="px-6 py-4">
                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-100">
                      PINJAM
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

      </div>
    </main>

  </div>
</body>

</html>