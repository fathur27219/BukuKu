@php
$active = 'bg-slate-900 text-white';
$inactive = 'text-slate-600 hover:bg-slate-100';

$user = auth()->user();
$isAdmin = $user && $user->role === 'admin';
$isSiswa = $user && $user->role === 'siswa';
@endphp

<!-- Sidebar -->
<aside class="hidden md:flex md:w-72 md:flex-col border-r border-slate-200 bg-white">
  @php
  $brandBg = $isAdmin ? 'bg-slate-900' : 'bg-sky-600';
  $brandText = $isAdmin ? 'Admin Perpustakaan' : 'Portal Siswa';
  @endphp

  <!-- Brand -->
  <div class="px-6 py-6">
    <div class="flex items-center gap-3">
      <div class="h-10 w-10 rounded-2xl {{ $brandBg }} text-white grid place-items-center">
        <i class="fa-solid fa-book-open"></i>
      </div>
      <div class="leading-tight">
        <div class="text-base font-semibold text-slate-900">BukuKu</div>
        <div class="text-xs text-slate-500">
          {{ $brandText }}
        </div>
      </div>
    </div>
  </div>

  <!-- Menu -->
  <nav class="px-3 pb-6 space-y-1">

    <!-- Utama -->
    <p class="px-3 pt-1 text-[11px] font-semibold tracking-wider text-slate-400 uppercase">Utama</p>

    <a href="{{ url('/dashboard') }}"
      class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
      {{ request()->is('dashboard') ? $active : $inactive }}">
      <i class="fa-solid fa-house w-5 text-center"></i>
      Dashboard
    </a>

    <!-- Master Data -->
    <p class="px-3 pt-4 text-[11px] font-semibold tracking-wider text-slate-400 uppercase">Master Data</p>

    @php
    $bookUrl = $isAdmin ? url('/books') : url('/siswa/books');
    $isActive = $isAdmin
    ? request()->is('books*')
    : request()->is('siswa/books*');
    @endphp

    <a href="{{ $bookUrl }}"
      class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
      {{ $isActive ? $active : $inactive }}">
      <i class="fa-solid fa-book w-5 text-center"></i>
      Koleksi Buku
    </a>

    @if($isAdmin)
    <a href="{{ url('/members') }}"
      class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
      {{ request()->is('members*') ? $active : $inactive }}">
      <i class="fa-solid fa-users w-5 text-center"></i>
      Data Anggota
    </a>
    @endif

    <!-- Transaksi -->
    <p class="px-3 pt-4 text-[11px] font-semibold tracking-wider text-slate-400 uppercase">Transaksi</p>

    <a href="{{ $isAdmin ? '/transactions' : '/siswa/transaksi' }}"
      class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
      {{ request()->is('transactions*') || request()->is('siswa/transaksi*') ? $active : $inactive }}">
      <i class="fa-solid fa-right-left w-5 text-center"></i>
      Transaksi
    </a>

    @if($isSiswa)

    <a href="/siswa/buku-saya"
      class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
      {{ request()->is('siswa/buku-saya*') ? $active : $inactive }}">
      <i class="fa-solid fa-book-open w-5 text-center"></i>
      Buku Saya
    </a>

    <a href="/siswa/riwayat"
      class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
      {{ request()->is('siswa/riwayat*') ? $active : $inactive }}">
      <i class="fa-solid fa-clock-rotate-left w-5 text-center"></i>
      Riwayat
    </a>

    @endif

    <!-- Sistem -->
    <p class="px-3 pt-4 text-[11px] font-semibold tracking-wider text-slate-400 uppercase">Sistem</p>

    <a href="{{ url('/settings') }}"
      class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
      {{ request()->is('settings*') ? $active : $inactive }}">
      <i class="fa-solid fa-gear w-5 text-center"></i>
      Pengaturan
    </a>

    <!-- Logout -->
    <div class="pt-6 mt-6 border-t border-slate-200">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit"
          class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-rose-600 hover:bg-rose-50">
          <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i>
          Logout
        </button>
      </form>
    </div>

  </nav>
</aside>