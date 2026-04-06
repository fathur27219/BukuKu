<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Buku Saya</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50">
<div class="flex min-h-screen">

  @include('sidebar')

  <main class="flex-1 p-6">
    <h2 class="text-xl font-bold mb-4">📖 Buku Saya</h2>

    <table class="w-full bg-white rounded-xl shadow">
      <thead class="bg-slate-100">
        <tr>
          <th class="p-3 text-left">Judul</th>
          <th>Status</th>
          <th>Tanggal Kembali</th>
        </tr>
      </thead>

      <tbody>
        @forelse($transactions as $t)
        <tr class="border-t">
          <td class="p-3">{{ $t->book->judul }}</td>
          <td>{{ $t->status }}</td>
          <td>{{ \Carbon\Carbon::parse($t->tanggal_kembali)->format('d M Y') }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="3" class="text-center p-6 text-gray-500">
            Belum ada buku dipinjam
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </main>

</div>
</body>
</html>