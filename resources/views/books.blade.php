<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Koleksi Buku Admin - BukuKu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-slate-50 text-slate-800 antialiased">
  <div class="min-h-screen flex">

    @include('sidebar')

    <!-- Main -->
    <main class="flex-1 overflow-y-auto">

      <!-- Header -->
      <header class="sticky top-0 z-10 bg-white/80 backdrop-blur border-b border-slate-200">
        <div class="px-6 md:px-8 py-4 flex justify-between items-center">
          <div>
            <h2 class="text-base md:text-lg font-semibold text-slate-900">Koleksi Buku</h2>
            <p class="text-xs md:text-sm text-slate-500">Kelola data buku: cari, filter, tambah, edit, hapus</p>
          </div>

          <div class="flex items-center gap-3">
            <div class="text-right leading-tight">
              <p class="text-sm font-medium text-slate-900">{{ optional(auth()->user())->nama ?? optional(auth()->user())->name ?? 'User' }}</p>
              <p class="text-[11px] text-slate-500 uppercase tracking-wide">{{ optional(auth()->user())->role ?? 'User' }}</p>
            </div>
            <img class="h-10 w-10 rounded-full ring-2 ring-slate-200"
              src="https://ui-avatars.com/api/?name={{ urlencode(optional(auth()->user())->nama ?? optional(auth()->user())->name ?? 'User') }}&background=e2e8f0&color=0f172a"
              alt="User profile">
          </div>
        </div>
      </header>

      <div class="px-6 md:px-8 py-8 space-y-6">

        <!-- Hero -->
        <section class="rounded-2xl border border-slate-200 bg-white p-6 md:p-7">
          <h1 class="text-xl md:text-2xl font-semibold text-slate-900">Kelola Koleksi Buku</h1>
          <p class="mt-1 text-sm text-slate-600">Temukan, tambah, edit, atau hapus buku dari koleksi perpustakaan.</p>

          <div class="mt-4 flex flex-wrap gap-2">
            <button type="button" onclick="openAddModal()"
              class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
              <i class="fas fa-plus"></i>
              Tambah Buku
            </button>
            <a href="/transactions"
              class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
              <i class="fas fa-clock"></i>
              Lihat Transaksi
            </a>
          </div>
        </section>

        <!-- Stats -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-semibold text-slate-500 tracking-wide">TOTAL BUKU</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $books->total() }}</p>
            <p class="mt-1 text-xs text-slate-500">Semua data buku</p>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-semibold text-slate-500 tracking-wide">TERSEDIA</p>
            <p class="mt-2 text-2xl font-semibold text-emerald-600">{{ $availableBooks ?? 0 }}</p>
            <p class="mt-1 text-xs text-slate-500">Stok aman</p>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-semibold text-slate-500 tracking-wide">DIPINJAM</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $borrowedBooks ?? 0 }}</p>
            <p class="mt-1 text-xs text-slate-500">Sedang berjalan</p>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <p class="text-xs font-semibold text-slate-500 tracking-wide">KATEGORI</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $categoriesCount ?? 0 }}</p>
            <p class="mt-1 text-xs text-slate-500">Total kategori</p>
          </div>
        </section>

        <!-- Search -->
        <section class="rounded-2xl border border-slate-200 bg-white p-6">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
              <h3 class="text-base font-semibold text-slate-900">Cari & Filter</h3>
              <p class="text-sm text-slate-500">Cari berdasarkan judul, penulis, atau kategori.</p>
            </div>
          </div>

          <form id="searchForm" method="GET" action="{{ url('/books') }}" class="mt-5 space-y-4">
            <div class="flex flex-col md:flex-row gap-3">
              <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search"
                  class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-300 focus:border-slate-300 bg-white"
                  placeholder="Cari judul, penulis, kata kunci..."
                  value="{{ request('search') }}" />
              </div>
              <button type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-5 py-3 text-sm font-medium text-white hover:bg-slate-800">
                Cari
              </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
              <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">Kategori</label>
                <select name="category"
                  class="w-full py-3 px-3 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-slate-300"
                  onchange="document.getElementById('searchForm').submit()">
                  <option value="">Semua Kategori</option>
                  <option value="Fiksi" {{ request('category') == 'Fiksi' ? 'selected' : '' }}>Fiksi</option>
                  <option value="Non-Fiksi" {{ request('category') == 'Non-Fiksi' ? 'selected' : '' }}>Non-Fiksi</option>
                  <option value="Teknologi" {{ request('category') == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                  <option value="Sains" {{ request('category') == 'Sains' ? 'selected' : '' }}>Sains</option>
                  <option value="Sejarah" {{ request('category') == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                  <option value="Bisnis" {{ request('category') == 'Bisnis' ? 'selected' : '' }}>Bisnis</option>
                </select>
              </div>

              <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">Status</label>
                <select name="status"
                  class="w-full py-3 px-3 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-slate-300"
                  onchange="document.getElementById('searchForm').submit()">
                  <option value="">Semua Status</option>
                  <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                  <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                </select>
              </div>

              <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">Urutkan</label>
                <select name="sort"
                  class="w-full py-3 px-3 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-slate-300"
                  onchange="document.getElementById('searchForm').submit()">
                  <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                  <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Judul A-Z</option>
                  <option value="author" {{ request('sort') == 'author' ? 'selected' : '' }}>Penulis A-Z</option>
                </select>
              </div>
            </div>
          </form>
        </section>

        <!-- Books -->
        <section class="rounded-2xl border border-slate-200 bg-white overflow-hidden">
          <div class="px-6 py-5 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <h3 class="text-base font-semibold text-slate-900">Daftar Buku</h3>
            <span class="text-sm text-slate-500">
              Menampilkan {{ $books->count() }} dari {{ $books->total() }} buku
            </span>
          </div>

          <div class="p-6">
            @if($books->count() > 0)

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
              @foreach($books as $book)
              @php
              // Normalisasi field (sesuai DB + fallback)
              $judul = $book->judul ?? $book->title ?? '-';
              $penulis = $book->pengarang ?? $book->author ?? '-';
              $penerbit = $book->penerbit ?? '-';
              $stok = (int)($book->stok ?? $book->stock ?? 0);
              $tahun = $book->tahun_terbit ?? $book->published_year ?? '—';
              $kategori = $book->kategori ?? $book->category ?? 'Umum';
              $desc = $book->deskripsi ?? $book->description ?? null;

              $badge = $stok > 5 ? 'bg-emerald-50 text-emerald-700 ring-emerald-100' :
              ($stok > 0 ? 'bg-amber-50 text-amber-700 ring-amber-100' : 'bg-rose-50 text-rose-700 ring-rose-100');
              $badgeText = $stok > 5 ? 'Tersedia' : ($stok > 0 ? "Tersedia $stok" : 'Habis');

              $catLower = strtolower($kategori ?? '');
              $icon = '📚';
              if (str_contains($catLower, 'teknologi')) $icon = '💻';
              elseif (str_contains($catLower, 'sains')) $icon = '🔬';
              elseif (str_contains($catLower, 'sejarah')) $icon = '🏛️';
              elseif (str_contains($catLower, 'bisnis')) $icon = '💼';
              elseif (str_contains($catLower, 'fiksi')) $icon = '✨';
              @endphp

              <div class="rounded-2xl border border-slate-200 bg-white hover:shadow-md transition-shadow overflow-hidden">
                <div class="relative h-40 overflow-hidden bg-slate-100 border-b border-slate-200">
                  <img src="{{ $book->gambar ?? 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $judul }} cover" class="h-full w-full object-cover" />
                  <span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-[11px] font-semibold text-slate-700 ring-1 ring-slate-200">
                    {{ $kategori }}
                  </span>
                </div>

                <div class="p-5">
                  <h4 class="font-semibold text-slate-900 line-clamp-1">{{ $judul }}</h4>

                  <p class="mt-1 text-sm text-slate-600 flex items-center gap-2">
                    <i class="fas fa-user text-slate-400"></i>
                    <span class="line-clamp-1">{{ $penulis }}</span>
                  </p>

                  <p class="mt-1 text-xs text-slate-500 flex items-center gap-2">
                    <i class="fas fa-building text-slate-400"></i>
                    <span class="line-clamp-1">{{ $penerbit }}</span>
                  </p>

                  <p class="mt-3 text-sm text-slate-500 line-clamp-2">
                    {{ $desc ? \Illuminate\Support\Str::limit($desc, 80) : 'Tidak ada deskripsi' }}
                  </p>

                  <div class="mt-4 flex items-center justify-between text-xs text-slate-500">
                    <span class="flex items-center gap-2">
                      <i class="fas fa-calendar text-slate-400"></i>
                      {{ $tahun }}
                    </span>
                    <span class="flex items-center gap-2">
                      <i class="fas fa-cubes text-slate-400"></i>
                      Stok: {{ $stok }}
                    </span>
                  </div>

                  <div class="mt-4">
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $badge }}">
                      {{ $badgeText }}
                    </span>
                  </div>

                  <div class="mt-4 flex gap-2">
                    @if($stok > 0)
                    <form action="{{ url('/transactions/pinjam') }}" method="POST" class="flex-1">
                      @csrf
                      <input type="hidden" name="book_id" value="{{ $book->id }}">
                      <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-3 py-2 text-sm font-medium text-white hover:bg-slate-800">
                        <i class="fas fa-book-reader"></i>
                        Pinjam
                      </button>
                    </form>
                    @else
                    <button type="button"
                      class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-slate-100 px-3 py-2 text-sm font-medium text-slate-500 cursor-not-allowed">
                      <i class="fas fa-times-circle"></i>
                      Habis
                    </button>
                    @endif

                    <button type="button" data-book='@json($book, JSON_HEX_APOS|JSON_HEX_QUOT)'
                      onclick="openEditModalFromData(this)"
                      class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 hover:bg-slate-50"
                      title="Edit">
                      <i class="fas fa-pen"></i>
                    </button>

                    <form action="{{ url('/books/' . $book->id) }}" method="POST" class="inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-rose-600 hover:bg-rose-50"
                        title="Hapus">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
              @endforeach
            </div>

            @else
            <div class="text-center py-14">
              <div class="text-5xl text-slate-300 mb-4"><i class="fas fa-book-open"></i></div>
              <h3 class="text-lg font-semibold text-slate-900 mb-1">Belum ada buku</h3>
              <p class="text-sm text-slate-500 mb-6">Tambahkan buku pertama untuk memulai koleksi.</p>
              <button type="button" onclick="openAddModal()"
                class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-3 text-sm font-medium text-white hover:bg-slate-800">
                <i class="fas fa-plus"></i>
                Tambah Buku
              </button>
            </div>
            @endif
          </div>

          @if($books->hasPages())
          <div class="px-6 py-5 border-t border-slate-200">
            <div class="flex flex-wrap justify-center items-center gap-2">
              @if($books->onFirstPage())
              <span class="px-3 py-2 rounded-xl bg-slate-100 text-slate-400 cursor-not-allowed">
                <i class="fas fa-chevron-left"></i>
              </span>
              @else
              <a href="{{ $books->previousPageUrl() }}"
                class="px-3 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50">
                <i class="fas fa-chevron-left"></i>
              </a>
              @endif

              @for($i = 1; $i <= $books->lastPage(); $i++)
                @if($i == $books->currentPage())
                <span class="px-4 py-2 rounded-xl bg-slate-900 text-white font-semibold">{{ $i }}</span>
                @else
                <a href="{{ $books->url($i) }}"
                  class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50">
                  {{ $i }}
                </a>
                @endif
                @endfor

                @if($books->hasMorePages())
                <a href="{{ $books->nextPageUrl() }}"
                  class="px-3 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50">
                  <i class="fas fa-chevron-right"></i>
                </a>
                @else
                <span class="px-3 py-2 rounded-xl bg-slate-100 text-slate-400 cursor-not-allowed">
                  <i class="fas fa-chevron-right"></i>
                </span>
                @endif
            </div>
          </div>
          @endif
        </section>

      </div>
    </main>
  </div>

  <!-- MODAL ADD -->
  <div id="addModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/40" onclick="closeAddModal()"></div>

    <div class="relative h-full w-full flex items-start justify-center p-4 overflow-y-auto">
      <div class="w-full max-w-lg rounded-2xl border border-slate-200 bg-white shadow-xl overflow-hidden max-h-[calc(100vh-4rem)]">
        <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
          <h3 class="text-sm font-semibold text-slate-900">Tambah Buku Baru</h3>
          <button type="button" onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600">
            <i class="fas fa-times"></i>
          </button>
        </div>

        <form action="{{ url('/books') }}" method="POST" id="addBookForm" enctype="multipart/form-data" class="p-5 flex flex-col h-full">
          @csrf

          <div class="space-y-3 overflow-y-auto pr-1 pb-4">
            <div>
              <label class="block text-[11px] font-medium text-slate-500 mb-1">Judul *</label>
              <input type="text" name="judul" required
                class="w-full px-3 py-2.5 rounded-lg border border-slate-200 bg-white focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-300">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label class="block text-[11px] font-medium text-slate-500 mb-1">Penulis *</label>
                <input type="text" name="pengarang" required
                  class="w-full px-3 py-2.5 rounded-lg border border-slate-200 bg-white focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-300">
              </div>
              <div>
                <label class="block text-[11px] font-medium text-slate-500 mb-1">Penerbit *</label>
                <input type="text" name="penerbit" required
                  class="w-full px-3 py-2.5 rounded-lg border border-slate-200 bg-white focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-300">
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label class="block text-[11px] font-medium text-slate-500 mb-1">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" min="1900" max="{{ date('Y') }}"
                  class="w-full px-3 py-2.5 rounded-lg border border-slate-200 bg-white focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-300">
              </div>
              <div>
                <label class="block text-[11px] font-medium text-slate-500 mb-1">Stok *</label>
                <input type="number" name="stok" min="0" required
                  class="w-full px-3 py-2.5 rounded-lg border border-slate-200 bg-white focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-300">
              </div>
            </div>

            <!-- OPTIONAL (kalau kolom ada di DB, kalau tidak, aman saja asalkan controller ignore) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label class="block text-[11px] font-medium text-slate-500 mb-1">Kategori (opsional)</label>
                <input type="text" name="kategori"
                  class="w-full px-3 py-2.5 rounded-lg border border-slate-200 bg-white focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-300"
                  placeholder="Misal: Fiksi">
              </div>
              <div>
                <label class="block text-[11px] font-medium text-slate-500 mb-1">Jenis Buku (opsional)</label>
                <input type="text" name="jenis"
                  class="w-full px-3 py-2.5 rounded-lg border border-slate-200 bg-white focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-300"
                  placeholder="Misal: Pelajaran">
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label class="block text-[11px] font-medium text-slate-500 mb-1">Kode Buku (opsional)</label>
                <input type="text" name="kode_buku"
                  class="w-full px-3 py-2.5 rounded-lg border border-slate-200 bg-white focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-300"
                  placeholder="Misal: BK-001">
              </div>
              <div>
                <label class="block text-[11px] font-medium text-slate-500 mb-1">Gambar Sampul (opsional)</label>
                <input type="file" name="gambar" accept="image/*"
                  class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-slate-800" />
              </div>
            </div>

            <div>
              <label class="block text-[11px] font-medium text-slate-500 mb-1">Deskripsi (opsional)</label>
              <textarea name="deskripsi" rows="3"
                class="w-full px-3 py-2.5 rounded-lg border border-slate-200 bg-white focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-300"></textarea>
            </div>

          </div>

          <div class="sticky bottom-0 left-0 z-10 mt-4 flex justify-end gap-2 border-t border-slate-200 bg-white pt-4">
            <button type="button" onclick="closeAddModal()"
              class="rounded-lg px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
              Batal
            </button>
            <button type="submit"
              class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
              Simpan
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <!-- MODAL EDIT -->
  <div id="editModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/40" onclick="closeEditModal()"></div>

    <div class="relative h-full w-full flex items-start justify-center p-4 overflow-y-auto">
      <div class="w-full max-w-lg rounded-2xl border border-slate-200 bg-white shadow-xl overflow-hidden max-h-[calc(100vh-4rem)]">

        <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
          <h3 class="text-sm font-semibold text-slate-900">Edit Buku</h3>
          <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
            <i class="fas fa-times"></i>
          </button>
        </div>

        <form id="editBookForm" method="POST" enctype="multipart/form-data" class="p-5 flex flex-col h-full">
          @csrf
          @method('PUT')
          <input type="hidden" id="editBookId" />

          <div class="space-y-3 overflow-y-auto pr-1 pb-4">
            <div>
              <label class="block text-[11px] font-medium text-slate-500 mb-1">Judul *</label>
              <input type="text" id="editJudul" name="judul" required
                class="w-full px-3 py-2.5 rounded-lg border border-slate-200 bg-white focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-300">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label class="block text-[11px] font-medium text-slate-500 mb-1">Penulis *</label>
                <input type="text" id="editPengarang" name="pengarang" required
                  class="w-full px-3 py-2.5 rounded-lg border border-slate-200 bg-white focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-300">
              </div>
              <div>
                <label class="block text-[11px] font-medium text-slate-500 mb-1">Penerbit *</label>
                <input type="text" id="editPenerbit" name="penerbit" required
                  class="w-full px-3 py-2.5 rounded-lg border border-slate-200 bg-white focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-300">
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label class="block text-[11px] font-medium text-slate-500 mb-1">Tahun Terbit</label>
                <input type="number" id="editTahunTerbit" name="tahun_terbit" min="1900" max="{{ date('Y') }}"
                  class="w-full px-3 py-2.5 rounded-lg border border-slate-200 bg-white focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-300">
              </div>
              <div>
                <label class="block text-[11px] font-medium text-slate-500 mb-1">Stok *</label>
                <input type="number" id="editStok" name="stok" min="0" required
                  class="w-full px-3 py-2.5 rounded-lg border border-slate-200 bg-white focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-300">
              </div>
            </div>

            <!-- Optional fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label class="block text-[11px] font-medium text-slate-500 mb-1">Kategori (opsional)</label>
                <input type="text" id="editCategory" name="kategori"
                  class="w-full px-3 py-2.5 rounded-lg border border-slate-200 bg-white focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-300">
              </div>
              <div>
                <label class="block text-[11px] font-medium text-slate-500 mb-1">Jenis Buku (opsional)</label>
                <input type="text" id="editJenis" name="jenis"
                  class="w-full px-3 py-2.5 rounded-lg border border-slate-200 bg-white focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-300">
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label class="block text-[11px] font-medium text-slate-500 mb-1">Kode Buku (opsional)</label>
                <input type="text" id="editKodeBuku" name="kode_buku"
                  class="w-full px-3 py-2.5 rounded-lg border border-slate-200 bg-white focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-300">
              </div>
              <div>
                <label class="block text-[11px] font-medium text-slate-500 mb-1">Gambar Sampul (opsional)</label>
                <input type="file" id="editGambar" name="gambar" accept="image/*"
                  class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-slate-800" />
              </div>
            </div>

            <div>
              <label class="block text-[11px] font-medium text-slate-500 mb-1">Deskripsi (opsional)</label>
              <textarea id="editDescription" name="deskripsi" rows="3"
                class="w-full px-3 py-2.5 rounded-lg border border-slate-200 bg-white focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-300"></textarea>
            </div>

          </div>

          <div class="sticky bottom-0 left-0 z-10 mt-4 flex justify-end gap-2 border-t border-slate-200 bg-white pt-4">
            <button type="button" onclick="closeEditModal()"
              class="rounded-lg px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
              Batal
            </button>
            <button type="submit"
              class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
              Update
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <script>
    function openAddModal() {
      document.getElementById('addModal').classList.remove('hidden');
    }

    function closeAddModal() {
      document.getElementById('addModal').classList.add('hidden');
      document.getElementById('addBookForm').reset();
    }

    function openEditModal(book) {
      // Normalisasi field dari backend (DB vs UI)
      const id = book.id;
      const judul = book.judul ?? book.title ?? '';
      const pengarang = book.pengarang ?? book.author ?? '';
      const penerbit = book.penerbit ?? '';
      const tahunTerbit = book.tahun_terbit ?? book.published_year ?? '';
      const stok = book.stok ?? book.stock ?? 0;
      const category = book.kategori ?? book.category ?? '';
      const jenis = book.jenis ?? book.type ?? '';
      const kodeBuku = book.kode_buku ?? '';
      const description = book.deskripsi ?? book.description ?? '';

      document.getElementById('editBookId').value = id;
      document.getElementById('editJudul').value = judul;
      document.getElementById('editPengarang').value = pengarang;
      document.getElementById('editPenerbit').value = penerbit;
      document.getElementById('editTahunTerbit').value = tahunTerbit;
      document.getElementById('editStok').value = stok;
      document.getElementById('editCategory').value = category;
      document.getElementById('editJenis').value = jenis;
      document.getElementById('editKodeBuku').value = kodeBuku;
      document.getElementById('editDescription').value = description;

      // Set action ke /books/{id}
      document.getElementById('editBookForm').action = `/books/${id}`;
      document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('editModal').classList.add('hidden');
    }

    function openEditModalFromData(button) {
      const book = JSON.parse(button.dataset.book);
      openEditModal(book);
    }
  </script>

  @if(session('success'))
  <script>
    alert(<?php echo json_encode(session('success')); ?>);
  </script>
  @endif
  @if(session('error'))
  <script>
    alert(<?php echo json_encode(session('error')); ?>);
  </script>
  @endif
  @if($errors->any())
  <script>
    alert(<?php echo json_encode('Terjadi kesalahan: ' . $errors->first()); ?>);
  </script>
  @endif
</body>

</html>