<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Anggota - BukuKu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-slate-50 text-slate-800 antialiased">
  <div class="min-h-screen flex">

    {{-- SIDEBAR: pakai sidebar yang sudah kamu pakai, tinggal tambah menu Anggota --}}
    @include('sidebar')

    <main class="flex-1 overflow-y-auto">

      <header class="sticky top-0 z-10 bg-white/80 backdrop-blur border-b border-slate-200">
        <div class="px-6 md:px-8 py-4 flex justify-between items-center">
          <div>
            <h2 class="text-base md:text-lg font-semibold text-slate-900">Anggota</h2>
            <p class="text-xs md:text-sm text-slate-500">Kelola data anggota perpustakaan</p>
          </div>

          <div class="flex items-center gap-3">
            <div class="text-right leading-tight">
              <p class="text-sm font-medium text-slate-900">{{ optional(auth()->user())->nama ?? optional(auth()->user())->name ?? 'User' }}</p>
              <p class="text-[11px] text-slate-500 uppercase tracking-wide">{{ optional(auth()->user())->role ?? 'ADMIN' }}</p>
            </div>
            <img class="h-10 w-10 rounded-full ring-2 ring-slate-200"
              src="https://ui-avatars.com/api/?name={{ urlencode(optional(auth()->user())->nama ?? optional(auth()->user())->name ?? 'User') }}&background=e2e8f0&color=0f172a"
              alt="User profile">
          </div>
        </div>
      </header>

      <div class="px-6 md:px-8 py-8 space-y-6">

        <section class="rounded-2xl border border-slate-200 bg-white p-6 md:p-7">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
              <h1 class="text-xl md:text-2xl font-semibold text-slate-900">Master Data Anggota</h1>
              <p class="mt-1 text-sm text-slate-600">Tambah, cari, edit, nonaktifkan anggota.</p>
            </div>
            <button onclick="openAddModal()"
              class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
              <i class="fa-solid fa-plus"></i> Tambah Anggota
            </button>
          </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-6">
          <form method="GET" class="space-y-4">
            <div class="flex flex-col md:flex-row gap-3">
              <div class="flex-1 relative">
                <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                  class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-300"
                  placeholder="Cari nama / kode anggota / kelas">
              </div>
              <select name="status" class="px-3 py-3 rounded-xl border border-slate-200 bg-white"
                onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status')=='active'?'selected':'' }}>Aktif</option>
                <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Nonaktif</option>
              </select>
              <button class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-medium text-white hover:bg-slate-800">
                Cari
              </button>
            </div>
          </form>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white overflow-hidden">
          <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-base font-semibold text-slate-900">Daftar Anggota</h3>
            <span class="text-sm text-slate-500">Total: {{ $members->total() }}</span>
          </div>

          <div class="p-6 overflow-x-auto">
            <table class="min-w-full">
              <thead class="bg-slate-50">
                <tr class="text-left text-[11px] font-semibold text-slate-500 uppercase border-b border-slate-200">
                  <th class="py-3 px-3">Kode</th>
                  <th class="py-3 px-3">Nama</th>
                  <th class="py-3 px-3">Kelas</th>
                  <th class="py-3 px-3">Telepon</th>
                  <th class="py-3 px-3">Status</th>
                  <th class="py-3 px-3">Aksi</th>
                </tr>
              </thead>

              <tbody class="divide-y divide-slate-100">
                @forelse($members as $m)
                <tr class="text-sm text-slate-700 hover:bg-slate-50">
                  <td class="py-4 px-3 font-semibold">{{ $m->kode_anggota }}</td>
                  <td class="py-4 px-3">{{ $m->nama }}</td>
                  <td class="py-4 px-3">{{ $m->kelas ?? '-' }}</td>
                  <td class="py-4 px-3">{{ $m->telepon ?? '-' }}</td>
                  <td class="py-4 px-3">
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1
                        {{ $m->is_active ? 'bg-emerald-50 text-emerald-700 ring-emerald-100' : 'bg-slate-100 text-slate-600 ring-slate-200' }}">
                      {{ $m->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                  </td>
                  <td class="py-4 px-3 flex gap-2">
                    <button data-member='@json($m, JSON_HEX_APOS|JSON_HEX_QUOT)'
                      onclick="openEditModalFromData(this)"
                      class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                      <i class="fa-solid fa-pen"></i>
                    </button>

                    <form action="{{ url('/members/toggle/'.$m->id) }}" method="POST">
                      @csrf
                      <button class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm hover:bg-slate-50">
                        <i class="fa-solid {{ $m->is_active ? 'fa-user-slash text-rose-600' : 'fa-user-check text-emerald-600' }}"></i>
                      </button>
                    </form>

                    <form action="{{ url('/members/'.$m->id) }}" method="POST"
                      onsubmit="return confirm('Hapus anggota ini?')">
                      @csrf
                      @method('DELETE')
                      <button class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-rose-600 hover:bg-rose-50">
                        <i class="fa-solid fa-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="py-12 text-center text-slate-500">Belum ada anggota.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="px-6 py-5 border-t border-slate-200">
            {{ $members->links() }}
          </div>
        </section>
      </div>
    </main>
  </div>

  <!-- MODAL ADD -->
  <div id="addModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/40" onclick="closeAddModal()"></div>
    <div class="relative h-full w-full flex items-center justify-center p-4">
      <div class="w-full max-w-lg rounded-2xl border border-slate-200 bg-white shadow-xl overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
          <h3 class="text-sm font-semibold text-slate-900">Tambah Anggota</h3>
          <button onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <form action="{{ url('/members') }}" method="POST" id="addForm" class="p-5 space-y-3">
          @csrf
          <div>
            <label class="block text-[11px] font-medium text-slate-500 mb-1">Kode Anggota (NIS/NIM) *</label>
            <input name="kode_anggota" required class="w-full px-3 py-2.5 rounded-lg border border-slate-200">
          </div>
          <div>
            <label class="block text-[11px] font-medium text-slate-500 mb-1">Nama *</label>
            <input name="nama" required class="w-full px-3 py-2.5 rounded-lg border border-slate-200">
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
              <label class="block text-[11px] font-medium text-slate-500 mb-1">Kelas</label>
              <input name="kelas" class="w-full px-3 py-2.5 rounded-lg border border-slate-200">
            </div>
            <div>
              <label class="block text-[11px] font-medium text-slate-500 mb-1">Telepon</label>
              <input name="telepon" class="w-full px-3 py-2.5 rounded-lg border border-slate-200">
            </div>
          </div>
          <div>
            <label class="block text-[11px] font-medium text-slate-500 mb-1">Alamat</label>
            <textarea name="alamat" rows="2" class="w-full px-3 py-2.5 rounded-lg border border-slate-200"></textarea>
          </div>
          <select name="user_id" required class="w-full px-3 py-2 border rounded">
            <option value="">-- Pilih User Siswa --</option>
            @foreach($users as $u)
            <option value="{{ $u->id }}">
              {{ $u->nama }} ({{ $u->username }})
            </option>
            @endforeach
          </select>
          <div class="pt-2 flex justify-end gap-2">
            <button type="button" onclick="closeAddModal()" class="rounded-lg px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Batal</button>
            <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- MODAL EDIT -->
  <div id="editModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/40" onclick="closeEditModal()"></div>
    <div class="relative h-full w-full flex items-center justify-center p-4">
      <div class="w-full max-w-lg rounded-2xl border border-slate-200 bg-white shadow-xl overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
          <h3 class="text-sm font-semibold text-slate-900">Edit Anggota</h3>
          <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <form id="editForm" method="POST" class="p-5 space-y-3">
          @csrf
          @method('PUT')

          <div>
            <label class="block text-[11px] font-medium text-slate-500 mb-1">Kode Anggota *</label>
            <input id="e_kode" name="kode_anggota" required class="w-full px-3 py-2.5 rounded-lg border border-slate-200">
          </div>
          <div>
            <label class="block text-[11px] font-medium text-slate-500 mb-1">Nama *</label>
            <input id="e_nama" name="nama" required class="w-full px-3 py-2.5 rounded-lg border border-slate-200">
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
              <label class="block text-[11px] font-medium text-slate-500 mb-1">Kelas</label>
              <input id="e_kelas" name="kelas" class="w-full px-3 py-2.5 rounded-lg border border-slate-200">
            </div>
            <div>
              <label class="block text-[11px] font-medium text-slate-500 mb-1">Telepon</label>
              <input id="e_telepon" name="telepon" class="w-full px-3 py-2.5 rounded-lg border border-slate-200">
            </div>
          </div>
          <div>
            <label class="block text-[11px] font-medium text-slate-500 mb-1">Alamat</label>
            <textarea id="e_alamat" name="alamat" rows="2" class="w-full px-3 py-2.5 rounded-lg border border-slate-200"></textarea>
          </div>
          <div class="flex items-center gap-2">
            <input id="e_active" type="checkbox" name="is_active" value="1" class="rounded">
            <label class="text-sm text-slate-600">Aktif</label>
          </div>

          <div class="pt-2 flex justify-end gap-2">
            <button type="button" onclick="closeEditModal()" class="rounded-lg px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Batal</button>
            <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">Update</button>
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
      document.getElementById('addForm').reset();
    }

    function openEditModal(m) {
      document.getElementById('editForm').action = `/members/${m.id}`;
      document.getElementById('e_kode').value = m.kode_anggota ?? '';
      document.getElementById('e_nama').value = m.nama ?? '';
      document.getElementById('e_kelas').value = m.kelas ?? '';
      document.getElementById('e_telepon').value = m.telepon ?? '';
      document.getElementById('e_alamat').value = m.alamat ?? '';
      document.getElementById('e_active').checked = !!m.is_active;
      document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('editModal').classList.add('hidden');
    }

    function openEditModalFromData(button) {
      const member = JSON.parse(button.dataset.member);
      openEditModal(member);
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