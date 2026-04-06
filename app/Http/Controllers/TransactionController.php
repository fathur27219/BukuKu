<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function indexAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/siswa/books');
        }

        $transactions = Transaction::with('member', 'book')->get();
        $books = Book::orderBy('judul')->get();
        $members = Member::where('is_active', true)->get();

        return view('transaction', compact('transactions', 'books', 'members'));
    }

    // ================= SISWA =================
    public function indexSiswa()
    {
        if (Auth::user()->role !== 'siswa') {
            return redirect('/transactions');
        }

        $member = Member::where('user_id', Auth::id())->first();

        if (!$member) {
            return redirect()->back()->with('error', 'Data anggota tidak ditemukan');
        }

        $transactions = Transaction::with('member', 'book')
            ->where('member_id', $member->id)
            ->get();

        $books = Book::orderBy('judul')->get();

        return view('siswa.transaksi', compact('transactions', 'books'));
    }

    // Peminjaman buku
   public function pinjam(Request $request)
{
    $request->validate([
        'book_id' => 'required|exists:books,id',
        'tanggal_kembali' => 'nullable|date|after:tanggal_pinjam', // tanggal kembali opsional
    ]);

    $book = Book::findOrFail($request->book_id);

    if ($book->stok < 1) {
        return redirect()->back()->with('error', 'Stok buku habis');
    }

    $member = Member::where('user_id', Auth::id())->first();

    if (!$member) {
        return redirect()->back()->with('error', 'Data anggota tidak ditemukan');
    }

    if (!$member->is_active) {
        return redirect()->back()->with('error', 'Status Anda tidak aktif, tidak dapat melakukan transaksi');
    }

    // Cek transaksi telat
    $telat = $member->transactions()
        ->where('status', 'dipinjam')
        ->whereDate('tanggal_kembali', '<', now())
        ->exists();

    if ($telat) {
        return redirect()->back()->with('error', 'Anda memiliki buku yang belum dikembalikan dan sudah melewati tanggal kembali. Silakan kembalikan dulu buku tersebut.');
    }


    $tanggal_kembali_request = $request->tanggal_kembali
        ? Carbon::parse($request->tanggal_kembali)
        : Carbon::now()->addDays(7);

    // Maksimal 14 hari
    if ($tanggal_kembali_request->diffInDays(now()) > 14) {
        return redirect()->back()->with('error', 'Maksimal tanggal pengembalian adalah 14 hari dari sekarang.');
    }

    Transaction::create([
        'member_id' => $member->id,
        'book_id' => $request->book_id,
        'tanggal_pinjam' => now(),
        'tanggal_kembali' => $tanggal_kembali_request,
        'status' => 'dipinjam',
        'denda' => 0
    ]);

    $book->decrement('stok');

    return redirect()->back()->with('success', 'Buku berhasil dipinjam');
}

    // Pengembalian buku
    public function kembalikan($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status === 'dikembalikan') {
            return redirect()->back()->with('error', 'Buku sudah dikembalikan');
        }

        $transaction->update([
            'status' => 'dikembalikan',
            'tanggal_dikembalikan' => now()
        ]);

        // tambah stok
        $transaction->book->increment('stok');

        // 🔥 FIX: redirect berdasarkan role
        if (Auth::user()->role === 'admin') {
            return redirect('/transactions')->with('success', 'Buku berhasil dikembalikan');
        } else {
            return redirect('/siswa/transaksi')->with('success', 'Buku berhasil dikembalikan');
        }
    }

    public function bukuSaya()
    {
        $member = Member::where('user_id', Auth::id())->first();

        if (!$member) {
            return redirect()->back()->with('error', 'Akun belum diaktifkan admin');
        }

        $transactions = Transaction::with('book')
            ->where('member_id', $member->id)
            ->where('status', 'dipinjam')
            ->get();

        return view('siswa.buku-saya', compact('transactions'));
    }

    public function riwayat()
    {
        $member = Member::where('user_id', Auth::id())->first();

        if (!$member) {
            return redirect()->back()->with('error', 'Akun belum diaktifkan admin');
        }

        $transactions = Transaction::with('book')
            ->where('member_id', $member->id)
            ->get();

        return view('siswa.riwayat', compact('transactions'));
    }
}
