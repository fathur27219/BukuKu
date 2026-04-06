<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50">
<div class="flex min-h-screen">

  @include('sidebar')

  <main class="flex-1 p-6">
    <h2 class="text-xl font-bold mb-4">🕒 Riwayat</h2>

    <table class="w-full bg-white rounded-xl shadow">
      <thead class="bg-slate-100">
        <tr>
          <th class="p-3 text-left">Judul</th>
          <th>Status</th>
          <th>Tanggal Pinjam</th>
        </tr>
      </thead>

      <tbody>
        @foreach($transactions as $t)
        <tr class="border-t">
          <td class="p-3">{{ $t->book->judul }}</td>
          <td>{{ $t->status }}</td>
          <td>{{ \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d M Y') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </main>

</div>
</body>
</html>