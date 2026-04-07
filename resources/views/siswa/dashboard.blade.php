<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Siswa - BukuKu</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">
  <div class="min-h-screen flex">

    @include('sidebar')

    <main class="flex-1">
      <header class="sticky top-0 z-10 bg-white/80 backdrop-blur border-b border-slate-200">
        <div class="px-6 md:px-8 py-4 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
          <div>
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Dashboard Siswa</p>
            <h1 class="text-xl md:text-2xl font-semibold text-slate-900">Selamat datang di BukuKu</h1>
            <p class="mt-1 text-sm text-slate-600">Lihat koleksi buku, status pinjaman, dan rekomendasi terbaru.</p>
          </div>

          <div class="flex items-center gap-3">
            <div class="text-right leading-tight">
              <p class="text-sm font-medium text-slate-900">{{ optional(auth()->user())->nama ?? optional(auth()->user())->name ?? 'User' }}</p>
              <p class="text-[11px] text-slate-500 uppercase tracking-wide">{{ optional(auth()->user())->role ?? 'Siswa' }}</p>
            </div>
            <img
              class="h-10 w-10 rounded-full ring-2 ring-slate-200"
              src="https://ui-avatars.com/api/?name={{ urlencode(optional(auth()->user())->nama ?? optional(auth()->user())->name ?? 'User') }}&background=e2e8f0&color=0f172a"
              alt="User profile" />
          </div>
        </div>
      </header>

      <div class="px-6 md:px-8 py-8 space-y-6">

        <!-- Banner -->
        <section class="rounded-3xl border border-slate-200 bg-white p-6 md:p-8 shadow-sm">
          <div class="md:flex md:items-center md:justify-between gap-6">
            <div class="max-w-2xl">
              <p class="text-sm uppercase tracking-[0.24em] text-slate-500">Aplikasi Perpustakaan</p>
              <h2 class="mt-3 text-2xl font-semibold text-slate-900">Tampilan khusus siswa</h2>
              <p class="mt-3 text-sm text-slate-600">Periksa buku terbaru, lihat status pinjaman, dan pilih buku sesuai kategori serta deskripsi lengkap.</p>
            </div>

            {{-- <div class="rounded-3xl bg-slate-900 p-5 text-white shadow-xl">
              <div class="flex items-center gap-3">
                <div class="h-12 w-12 rounded-2xl bg-white/10 grid place-items-center text-slate-100">
                  <i class="fas fa-book fa-lg"></i>
                </div>
                <div>
                  <p class="text-sm uppercase tracking-[0.24em] text-slate-300">Aplikasi</p>
                  <p class="mt-1 text-xl font-semibold">BukuKu</p>
                </div>
              </div>
              <p class="mt-4 text-sm text-slate-300">Desain tampilan siswa dibuat lebih ringan, fokus pada buku, kategori, dan keterangan pinjaman.</p>
            </div> --}}
          </div>

          <div class="mt-6 flex flex-wrap gap-3">
            <a href="/siswa/books" class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
              Telusuri Koleksi Buku
            </a>
            <a href="/siswa/transaksi" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
              Lihat Transaksi
            </a>
          </div>
        </section>

        <!-- Statistik -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <div class="rounded-3xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Buku tersedia</p>
            <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $totalBuku }}</p>
            <p class="mt-2 text-sm text-slate-500">Koleksi siap dipinjam untuk siswa.</p>
          </div>
          <div class="rounded-3xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Pinjaman aktif</p>
            <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $jumlahPinjaman }}</p>
            <p class="mt-2 text-sm text-slate-500">Pinjaman yang sedang berjalan.</p>
          </div>
          <div class="rounded-3xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Kategori populer</p>
            <p class="mt-3 text-3xl font-semibold text-slate-900">4</p>
            <p class="mt-2 text-sm text-slate-500">Kategori buku yang sering dicari siswa.</p>
          </div>
          <div class="rounded-3xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Telat pengembalian</p>
            <p class="mt-3 text-3xl font-semibold text-rose-600">{{ $jumlahTelat }}</p>
            <p class="mt-2 text-sm text-slate-500">Buku yang perlu segera dikembalikan.</p>

            @if($jumlahTelat > 0)
                <ul class="mt-3 text-sm text-rose-600">
                    @foreach($telatTransaksi as $t)
                        <li>• {{ $t->book->judul }} (kembali: {{ \Carbon\Carbon::parse($t->tanggal_kembali)->format('d M Y') }})</li>
                    @endforeach
                </ul>
            @endif
          </div>
        </section>

        <!-- Informasi & Buku terbaik -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Buku terbaik</p>
            <h3 class="mt-4 text-lg font-semibold text-slate-900">Buku populer minggu ini</h3>
            <p class="mt-3 text-sm text-slate-600">Lihat buku dengan rating tinggi dan banyak dipinjam.</p>
            <ul class="mt-5 space-y-3 text-sm text-slate-700">
              <li>• Belajar Laravel Dasar</li>
              <li>• Manajemen Waktu Belajar</li>
              <li>• English for School</li>
            </ul>
          </article>

          <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Informasi</p>
            <h3 class="mt-4 text-lg font-semibold text-slate-900">Cara meminjam</h3>
            <p class="mt-3 text-sm text-slate-600">Pilih buku, klik pinjam, lalu tunggu konfirmasi. Setiap peminjaman berlaku 7 hari.</p>
          </article>

          <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Aksi cepat</p>
            <h3 class="mt-4 text-lg font-semibold text-slate-900">Cepat cari buku</h3>
            <p class="mt-3 text-sm text-slate-600">Gunakan halaman koleksi untuk melihat kategori, jenis, dan deskripsi lengkap setiap buku.</p>
          </article>
        </section>

        <!-- Transaksi terbaru -->
        <section class="rounded-3xl border border-slate-200 bg-white overflow-hidden">
          <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <div>
              <h3 class="text-base font-semibold text-slate-900">Transaksi terbaru</h3>
              <p class="text-sm text-slate-500">Ringkasan peminjaman terbaru untuk siswa.</p>
            </div>
            <a href="/siswa/transaksi" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">Lihat Semua</a>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left">
              <thead class="bg-slate-50">
                <tr class="text-[11px] uppercase tracking-wide text-slate-500">
                  <th class="px-6 py-3 font-semibold">Buku</th>
                  <th class="px-6 py-3 font-semibold">Kategori</th>
                  <th class="px-6 py-3 font-semibold">Tanggal</th>
                  <th class="px-6 py-3 font-semibold">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                @foreach($transaksiTerbaru as $t)
                  <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 font-medium text-slate-900">{{ $t->book->judul ?? '-'}}</td>
                    <td class="px-6 py-4 text-sm text-slate-700">{{ $t->book->kategori ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                      @if($t->status === 'dipinjam')
                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-100">Dipinjam</span>
                      @else
                        <span class="inline-flex items-center rounded-full bg-slate-50 px-3 py-1 text-xs font-semibold text-slate-700 ring-1 ring-slate-100">Dikembalikan</span>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </section>

      </div>
    </main>

  </div>
</body>

</html>
