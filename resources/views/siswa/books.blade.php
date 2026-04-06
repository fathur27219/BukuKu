<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Koleksi Buku Siswa - BukuKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-slate-50 text-slate-800 antialiased">
    <div class="min-h-screen flex">

        @include('sidebar')

        <main class="flex-1 overflow-y-auto">

            <header class="sticky top-0 z-20 bg-white border-b border-slate-200">
                <div class="px-6 py-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Koleksi Buku Siswa</p>
                        <h2 class="mt-1 text-2xl font-semibold text-slate-900">Temukan buku yang sesuai dengan minatmu</h2>
                        <p class="mt-1 text-sm text-slate-600">Lihat detail lengkap, kategori, jenis, dan deskripsi buku sebelum meminjam.</p>
                    </div>

                    <div class="text-right">
                        <p class="font-medium text-slate-900">{{ optional(auth()->user())->nama ?? optional(auth()->user())->name ?? 'User' }}</p>
                        <p class="text-xs text-slate-500">{{ optional(auth()->user())->role ?? 'Siswa' }}</p>
                    </div>
                </div>
            </header>

            <div class="px-6 py-8 space-y-6">
                <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">Cari buku favoritmu</h3>
                            <p class="mt-2 text-sm text-slate-600">Gunakan kolom pencarian untuk menemukan buku berdasarkan judul atau penulis.</p>
                        </div>
                        <form method="GET" action="{{ url('/siswa/books') }}" class="w-full lg:w-auto">
                            <div class="flex gap-2">
                                <input type="text" name="search" placeholder="Cari buku..." value="{{ request('search') }}"
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200" />
                                <button type="submit" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">Cari</button>
                            </div>
                        </form>
                    </div>
                </section>

                <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Kategori</p>
                        <h3 class="mt-3 text-xl font-semibold text-slate-900">Pilih sesuai minat</h3>
                        <p class="mt-2 text-sm text-slate-600">Temukan buku berdasarkan kategori khusus siswa seperti pelajaran, fiksi, motivasi, dan banyak lagi.</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Informasi lengkap</p>
                        <h3 class="mt-3 text-xl font-semibold text-slate-900">Detail buku yang jelas</h3>
                        <p class="mt-2 text-sm text-slate-600">Setiap buku menampilkan jenis, penerbit, tahun terbit, deskripsi, dan status stok.</p>
                    </div>
                </section>

                <section class="grid grid-cols-1 gap-6">
                    @if($books->count() > 0)
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                        @foreach($books as $book)
                        @php
                        $judul = $book->judul ?? $book->title ?? 'Judul tidak tersedia';
                        $penulis = $book->pengarang ?? $book->author ?? 'Penulis tidak tersedia';
                        $kategori = $book->kategori ?? $book->category ?? 'Umum';
                        $jenis = $book->jenis ?? $book->type ?? $book->jenis_buku ?? 'Umum';
                        $deskripsi = $book->deskripsi ?? $book->description ?? 'Deskripsi buku belum tersedia.';
                        $penerbit = $book->penerbit ?? $book->publisher ?? 'Tidak diketahui';
                        $tahun = $book->tahun_terbit ?? $book->published_year ?? '–';
                        $stok = (int)($book->stok ?? 0);
                        $cover = $book->gambar ?? $book->cover ?? null;
                        $coverUrl = $cover && filter_var($cover, FILTER_VALIDATE_URL)
                        ? $cover
                        : ($cover ? asset($cover) : 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=800&q=80');
                        @endphp

                        <article class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                            <div class="relative overflow-hidden bg-slate-100">
                                <img src="{{ $coverUrl }}" alt="{{ $judul }} cover" class="h-64 w-full object-cover" />
                                <div class="absolute left-4 top-4 rounded-full bg-slate-900/85 px-3 py-1 text-xs font-semibold uppercase text-white">{{ $kategori }}</div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between gap-3">
                                    <h3 class="text-xl font-semibold text-slate-900">{{ $judul }}</h3>
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-slate-600">{{ $jenis }}</span>
                                </div>
                                <p class="mt-2 text-sm text-slate-600">Penulis: <span class="font-medium text-slate-900">{{ $penulis }}</span></p>
                                <p class="mt-4 text-sm text-slate-600 leading-relaxed">{{ $deskripsi }}</p>

                                <div class="mt-5 grid grid-cols-2 gap-3 text-sm text-slate-700">
                                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                                        <p class="text-[10px] uppercase tracking-[0.24em] text-slate-500">Penerbit</p>
                                        <p class="mt-1 font-medium text-slate-900">{{ $penerbit }}</p>
                                    </div>
                                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                                        <p class="text-[10px] uppercase tracking-[0.24em] text-slate-500">Tahun</p>
                                        <p class="mt-1 font-medium text-slate-900">{{ $tahun }}</p>
                                    </div>
                                </div>

                                <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">Stok: {{ $stok }}</span>
                                    @if($stok > 0)
                                    <form action="{{ url('/transactions/pinjam') }}" method="POST" class="w-full sm:w-auto">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        <button type="submit" class="w-full rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 sm:w-auto">Pinjam Buku</button>
                                    </form>
                                    @else
                                    <button disabled class="w-full rounded-2xl bg-slate-200 px-4 py-3 text-sm font-semibold text-slate-500 sm:w-auto">Stok Habis</button>
                                    @endif
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                    @else
                    <div class="rounded-3xl border border-slate-200 bg-white p-8 text-center text-slate-600 shadow-sm">
                        <h3 class="text-lg font-semibold text-slate-900">Tidak ada buku</h3>
                        <p class="mt-2 text-sm">Coba gunakan kata kunci lain untuk mencari buku.</p>
                    </div>
                    @endif
                </section>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-base font-semibold text-slate-900">Navigasi buku</h3>
                            <p class="mt-1 text-sm text-slate-600">Lihat informasi lengkap buku sebelum meminjam.</p>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700">Jumlah buku: {{ $books->total() }}</span>
                    </div>
                    <div class="mt-6">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>

        </main>
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
            const kodeBuku = book.kode_buku ?? '';
            const description = book.deskripsi ?? book.description ?? '';

            document.getElementById('editBookId').value = id;
            document.getElementById('editJudul').value = judul;
            document.getElementById('editPengarang').value = pengarang;
            document.getElementById('editPenerbit').value = penerbit;
            document.getElementById('editTahunTerbit').value = tahunTerbit;
            document.getElementById('editStok').value = stok;
            document.getElementById('editCategory').value = category;
            document.getElementById('editKodeBuku').value = kodeBuku;
            document.getElementById('editDescription').value = description;

            // Set action ke /books/{id}
            document.getElementById('editBookForm').action = `/books/${id}`;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

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