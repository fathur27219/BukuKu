<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $member = Member::where('user_id', Auth::id())->first();

        $telatTransaksi = collect();
        $pinjamanAktif = collect();
        $transaksiTerbaru = collect();

        if ($member) {
            // 🔥 Transaksi yang telat
            $telatTransaksi = $member->transactions()
                ->where('status', 'dipinjam')
                ->where('tanggal_kembali', '<', now())
                ->get();

            // Pinjaman aktif
            $pinjamanAktif = $member->transactions()
                ->where('status', 'dipinjam')
                ->get();

            // 5 transaksi terbaru
            $transaksiTerbaru = $member->transactions()
                ->latest('tanggal_pinjam')
                ->take(5)
                ->get();
        }

        // Hitung jumlah buku telat dan pinjaman aktif
        $jumlahTelat = $telatTransaksi->count();
        $jumlahPinjaman = $pinjamanAktif->count();

        // Total buku tersedia (misal semua buku)
        $totalBuku = \App\Models\Book::sum('stok');

        return view('siswa.dashboard', compact(
            'telatTransaksi',
            'jumlahTelat',
            'jumlahPinjaman',
            'totalBuku',
            'transaksiTerbaru'
        ));
    }
}
