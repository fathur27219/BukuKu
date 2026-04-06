<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookController extends Controller
{
    // Tampilkan semua buku
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('judul', 'like', "%$s%")
                    ->orWhere('pengarang', 'like', "%$s%")
                    ->orWhere('kategori', 'like', "%$s%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'available') {
                $query->where('stok', '>', 0);
            } elseif ($request->status === 'borrowed') {
                $query->where('stok', '=', 0);
            }
        }

        if ($request->filled('category')) {
            $query->where('kategori', $request->category);
        }

        if ($request->sort === 'title') {
            $query->orderBy('judul');
        } elseif ($request->sort === 'author') {
            $query->orderBy('pengarang');
        } else {
            $query->latest();
        }

        $books = $query->paginate(12)->withQueryString();

        $availableBooks = Book::where('stok', '>', 0)->count();
        $borrowedBooks  = Book::where('stok', '=', 0)->count();
        $categoriesCount = Book::whereNotNull('kategori')->where('kategori', '!=', '')->distinct('kategori')->count('kategori');

        return view('books', compact('books', 'availableBooks', 'borrowedBooks', 'categoriesCount'));
    }


    // Simpan buku baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'pengarang' => 'nullable|string',
            'penerbit' => 'nullable|string',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
            'kategori' => 'nullable|string',
            'jenis' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $kode = Str::random(4);

        $data = [
            'kode_buku' => $kode,
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'stok' => $request->stok,
            'kategori' => $request->kategori,
            'jenis' => $request->jenis,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/books'), $fileName);
            $data['gambar'] = '/uploads/books/' . $fileName;
        }

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    // Tampilkan detail buku
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return response()->json($book);
    }

    // Update buku
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'judul' => 'required|string',
            'pengarang' => 'nullable|string',
            'penerbit' => 'nullable|string',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
            'kategori' => 'nullable|string',
            'jenis' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = [
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'stok' => $request->stok,
            'kategori' => $request->kategori,
            'jenis' => $request->jenis,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/books'), $fileName);
            $data['gambar'] = '/uploads/books/' . $fileName;
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diupdate.');
    }

    // Hapus buku
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }

    public function indexSiswa(Request $request)
    {
        $query = Book::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('judul', 'like', "%$s%")
                    ->orWhere('pengarang', 'like', "%$s%");
            });
        }

        $books = $query->paginate(12);

        $availableBooks = Book::where('stok', '>', 0)->count();
        $borrowedBooks  = Book::where('stok', '=', 0)->count();

        return view('siswa.books', compact('books', 'availableBooks', 'borrowedBooks'));
    }
}
