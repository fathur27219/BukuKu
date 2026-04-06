<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BukuKu - Sistem Informasi Perpustakaan Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);
        }

        .text-gradient {
            background: linear-gradient(to right, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body class="bg-white font-sans antialiased">

    <nav class="container mx-auto px-6 py-6 flex justify-between items-center">
        <div class="text-2xl font-bold text-indigo-700 tracking-tight">
            BukuKu
        </div>
        <div class="space-x-8 hidden md:flex items-center">
            <a href="#features" class="text-gray-600 hover:text-indigo-600 font-medium transition">Fitur</a>
            <a href="#stats" class="text-gray-600 hover:text-indigo-600 font-medium transition">Statistik</a>
            @if (Route::has('login'))
            @auth
            <a href="{{ url('/dashboard') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-full font-semibold hover:bg-indigo-700 transition shadow-md">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:text-indigo-800">Masuk</a>
            <a href="/register" class="text-blue-500 text-sm">
                Daftar
            </a> @endauth
            @endif
        </div>
    </nav>

    <section class="container mx-auto px-6 py-16 md:py-24 flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 mb-12 md:mb-0">
            <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
                Kelola Perpustakaan <br>
                <span class="text-gradient">Lebih Cerdas.</span>
            </h1>
            <p class="text-lg text-gray-600 mb-8 md:pr-12">
                BukuKu membantu institusi mengelola koleksi buku, sirkulasi peminjaman, dan manajemen anggota dalam satu platform yang terintegrasi dan mudah digunakan.
            </p>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-8 py-4 rounded-2xl font-bold text-center hover:bg-indigo-700 transition shadow-lg transform hover:-translate-y-1">
                    Mulai Sekarang — Gratis
                </a>
                <a href="#features" class="border border-gray-300 text-gray-700 px-8 py-4 rounded-2xl font-bold text-center hover:bg-gray-50 transition">
                    Lihat Fitur
                </a>
            </div>
        </div>
        <!-- <div class="md:w-1/2 relative">
            <div class="absolute -top-10 -left-10 w-72 h-72 bg-indigo-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
            <div class="absolute -bottom-10 -right-10 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
x        </div> -->
    </section>

    <section id="features" class="bg-gray-50 py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Mengapa Memilih BukuKu?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Sistem kami dirancang untuk mempermudah pustakawan dan memberikan kenyamanan bagi para peminjam.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-md transition">
                    <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Katalog Digital</h3>
                    <p class="text-gray-600">Pencarian buku cepat dengan filter kategori, penulis, dan ketersediaan stok secara real-time.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-md transition">
                    <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center text-purple-600 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Sirkulasi Otomatis</h3>
                    <p class="text-gray-600">Manajemen pinjam dan kembali yang otomatis menghitung denda jika terjadi keterlambatan.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-md transition">
                    <div class="w-14 h-14 bg-pink-100 rounded-2xl flex items-center justify-center text-pink-600 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Laporan Lengkap</h3>
                    <p class="text-gray-600">Ekspor laporan bulanan transaksi dan statistik buku terpopuler hanya dengan satu klik.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white py-12 border-t border-gray-100">
        <div class="container mx-auto px-6 text-center">
            <div class="text-xl font-bold text-indigo-700 mb-4">BukuKu</div>
            <p class="text-gray-500 text-sm">© 2026 BukuKu. Dibuat dengan ❤️ untuk Pustakawan Indonesia.</p>
        </div>
    </footer>

</body>

</html>