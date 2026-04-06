{{-- resources/views/transactions/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transaksi Siswa - BukuKu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    .line-clamp-1 {
      line-clamp: 1;
      overflow: hidden;
      display: -webkit-box;
      -webkit-line-clamp: 1;
      -webkit-box-orient: vertical;
    }
  </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">
  <div class="min-h-screen flex">

    @include('sidebar')

    <!-- Main -->
    <main class="flex-1 overflow-y-auto">

      <!-- Topbar -->
      <header class="sticky top-0 z-10 bg-white/80 backdrop-blur border-b border-slate-200">
        <div class="px-6 md:px-8 py-4 flex justify-between items-center">
          <div>
            <h2 class="text-base md:text-lg font-semibold text-slate-900">Transaksi</h2>
            <p class="text-xs md:text-sm text-slate-500">Pinjam buku & kelola pengembalian</p>
          </div>

          <div class="flex items-center gap-3">
            <div class="text-right leading-tight">
              <p class="text-sm font-medium text-slate-900">
                {{ optional(auth()->user())->nama ?? optional(auth()->user())->name ?? 'User' }}
              </p>
              <p class="text-[11px] text-slate-500 uppercase tracking-wide">
                {{ optional(auth()->user())->role ?? 'User' }}
              </p>
            </div>
            <img class="h-10 w-10 rounded-full ring-2 ring-slate-200"
              src="https://ui-avatars.com/api/?name={{ urlencode(optional(auth()->user())->nama ?? optional(auth()->user())->name ?? 'User') }}&background=e2e8f0&color=0f172a"
              alt="User profile">
          </div>
        </div>
      </header>

      <div class="px-6 md:px-8 py-8 space-y-6">

        <!-- Hero (simple) -->
        <section class="rounded-2xl border border-sky-200 bg-sky-50 p-6 md:p-7">
          <h1 class="text-xl md:text-2xl font-semibold text-slate-900">Portal Siswa</h1>
          <p class="mt-1 text-sm text-slate-600">Pinjam buku, lihat transaksi, dan kelola peminjaman dengan mudah.</p>
        </section>

        @php
        $total = $transactions->count();
        $dipinjam = $transactions->where('status', 'dipinjam')->count();
        $dikembalikan = $transactions->where('status', 'dikembalikan')->count();
        $terlambat = $transactions->filter(function($t){
        return $t->status === 'dipinjam'
        && $t->tanggal_kembali
        && \Carbon\Carbon::parse($t->tanggal_kembali)->lt(now());
        })->count();
        @endphp

        <!-- Stats -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-semibold text-slate-500 tracking-wide">TOTAL TRANSAKSI</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $total }}</p>
            <p class="mt-1 text-xs text-slate-500">Semua transaksi</p>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-semibold text-slate-500 tracking-wide">DIPINJAM</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $dipinjam }}</p>
            <p class="mt-1 text-xs text-slate-500">Sedang berjalan</p>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-semibold text-slate-500 tracking-wide">DIKEMBALIKAN</p>
            <p class="mt-2 text-2xl font-semibold text-emerald-600">{{ $dikembalikan }}</p>
            <p class="mt-1 text-xs text-slate-500">Selesai</p>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-semibold text-slate-500 tracking-wide">TERLAMBAT</p>
            <p class="mt-2 text-2xl font-semibold text-rose-600">{{ $terlambat }}</p>
            <p class="mt-1 text-xs text-slate-500">Perlu ditindak</p>
          </div>
        </section>

        <!-- Borrow Form -->
        <section class="rounded-2xl border border-slate-200 bg-white p-6">
          <div class="flex items-center justify-between">
            <div>
              <h3 class="text-base font-semibold text-slate-900">Pinjam Buku</h3>
              <p class="text-sm text-slate-500">Pilih anggota, pilih buku, dan tentukan tanggal kembali.</p>
            </div>
          </div>

          <form action="{{ url('/transactions/pinjam') }}" method="POST" class="mt-5 space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">

              {{-- PEMINJAM --}}
              <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">Peminjam</label>
                <input type="text"
                  value="{{ optional(auth()->user())->nama ?? optional(auth()->user())->name ?? 'User' }}"
                  class="w-full px-3 py-3 rounded-xl border border-slate-200 bg-gray-100"
                  readonly>
              </div>

              {{-- PILIH BUKU --}}
              <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">Pilih Buku *</label>
                <select name="book_id"
                  class="w-full px-3 py-3 rounded-xl border border-slate-200"
                  required>
                  <option value="">-- Pilih Buku --</option>
                  @foreach($books as $b)
                  <option value="{{ $b->id }}">
                    {{ $b->judul ?? $b->title }} (Stok: {{ $b->stok ?? 0 }})
                  </option>
                  @endforeach
                </select>
              </div>

              {{-- TANGGAL KEMBALI --}}
              <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">Tanggal Kembali *</label>
                <input type="date" name="tanggal_kembali"
                  class="w-full px-3 py-3 rounded-xl border border-slate-200"
                  required>
              </div>

            </div>

            <div class="flex justify-end">
              <button type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-3 text-sm font-medium text-white hover:bg-slate-800">
                <i class="fas fa-book-reader"></i>
                Proses Pinjam
              </button>
            </div>
          </form>
        </section>

        <!-- Transactions Table -->
        <section class="rounded-2xl border border-slate-200 bg-white overflow-hidden">
          <div class="px-6 py-5 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <h3 class="text-base font-semibold text-slate-900">Daftar Transaksi</h3>
            <span class="text-sm text-slate-500">Menampilkan {{ $transactions->count() }} transaksi</span>
          </div>

          <div class="p-6 overflow-x-auto">
            <table class="min-w-full">
              <thead class="bg-slate-50">
                <tr class="text-left text-[11px] font-semibold text-slate-500 uppercase border-b border-slate-200">
                  <th class="py-3 px-3">#</th>

                  {{-- ✅ TAMBAH: peminjam --}}
                  <th class="py-3 px-3">Peminjam</th>

                  <th class="py-3 px-3">Buku</th>
                  <th class="py-3 px-3">Tgl Pinjam</th>
                  <th class="py-3 px-3">Tgl Kembali</th>
                  <th class="py-3 px-3">Status</th>
                  <th class="py-3 px-3">Dikembalikan</th>
                  <th class="py-3 px-3">Aksi</th>
                </tr>
              </thead>

              <tbody class="divide-y divide-slate-100">
                @forelse($transactions as $i => $t)
                @php
                $isLate = $t->status === 'dipinjam'
                && $t->tanggal_kembali
                && \Carbon\Carbon::parse($t->tanggal_kembali)->lt(now());

                $badge = $t->status === 'dipinjam'
                ? ($isLate ? 'bg-rose-50 text-rose-700 ring-rose-100' : 'bg-amber-50 text-amber-700 ring-amber-100')
                : 'bg-emerald-50 text-emerald-700 ring-emerald-100';

                $badgeText = $t->status === 'dipinjam'
                ? ($isLate ? 'Dipinjam (Terlambat)' : 'Dipinjam')
                : 'Dikembalikan';
                @endphp

                <tr class="text-sm text-slate-700 hover:bg-slate-50">
                  <td class="py-4 px-3 font-semibold">{{ $i + 1 }}</td>

                  {{-- ✅ TAMBAH: isi peminjam --}}
                  <td class="py-4 px-3">
                    <div class="font-semibold text-slate-900 line-clamp-1">
                      {{ $t->member->nama ?? '-' }}
                    </div>
                    <div class="text-xs text-slate-500">
                      {{ $t->member->kode_anggota ?? '' }}
                    </div>
                  </td>

                  <td class="py-4 px-3">
                    <div class="font-semibold text-slate-900 line-clamp-1">
                      {{ $t->book->judul ?? $t->book->title ?? '-' }}
                    </div>
                    <div class="text-xs text-slate-500">ID: {{ $t->id }}</div>
                  </td>

                  <td class="py-4 px-3">
                    {{ $t->tanggal_pinjam ? \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d M Y') : '-' }}
                  </td>

                  <td class="py-4 px-3">
                    {{ $t->tanggal_kembali ? \Carbon\Carbon::parse($t->tanggal_kembali)->format('d M Y') : '-' }}
                  </td>

                  <td class="py-4 px-3">
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $badge }}">
                      {{ $badgeText }}
                    </span>
                  </td>

                  <td class="py-4 px-3">
                    {{ $t->tanggal_dikembalikan ? \Carbon\Carbon::parse($t->tanggal_dikembalikan)->format('d M Y') : '-' }}
                  </td>

                  <td class="py-4 px-3">
                    @if($t->status === 'dipinjam')
                    <form action="{{ url('/transactions/kembalikan/'.$t->id) }}" method="POST">
                      @csrf
                      <button type="submit"
                        onclick="return confirm('Yakin ingin mengembalikan buku ini?')"
                        class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-700">
                        <i class="fas fa-rotate-left"></i>
                        Kembalikan
                      </button>
                    </form>
                    @else
                    <span class="text-slate-400 text-xs">-</span>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="8" class="py-14 text-center">
                    <div class="text-slate-300 text-5xl mb-4">
                      <i class="fas fa-receipt"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-1">Belum ada transaksi</h3>
                    <p class="text-sm text-slate-500">Silakan lakukan peminjaman buku terlebih dahulu.</p>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </section>

      </div>
    </main>
  </div>

  <script>
    <?php if (session('success')): ?>
      alert(<?php echo json_encode(session('success')); ?>);
    <?php endif; ?>
    <?php if (session('error')): ?>
      alert(<?php echo json_encode(session('error')); ?>);
    <?php endif; ?>
    <?php if ($errors->any()): ?>
      alert(<?php echo json_encode('Terjadi kesalahan: ' . $errors->first()); ?>);
    <?php endif; ?>
  </script>
</body>

</html>