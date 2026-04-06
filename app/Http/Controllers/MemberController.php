<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $q = Member::with('user');

        if ($request->filled('search')) {
            $s = $request->search;
            $q->where(function ($w) use ($s) {
                $w->where('nama', 'like', "%$s%")
                    ->orWhere('kode_anggota', 'like', "%$s%")
                    ->orWhere('kelas', 'like', "%$s%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') $q->where('is_active', true);
            if ($request->status === 'inactive') $q->where('is_active', false);
        }

        // ✅ WAJIB: buat dulu members
        $members = $q->latest()->paginate(10)->withQueryString();

        // ✅ ambil user siswa yang belum punya member
        $users = User::where('role', 'siswa')
            ->whereDoesntHave('member')
            ->get();

        // ✅ return HARUS PALING BAWAH
        return view('members', compact('members', 'users'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'kode_anggota' => 'required|string|max:50|unique:members,kode_anggota',
            'nama' => 'required|string|max:120',
            'kelas' => 'nullable|string|max:50',
            'telepon' => 'nullable|string|max:30',
            'alamat' => 'nullable|string|max:255',
        ]);

        $data['is_active'] = true;

        Member::create($data);

        return redirect()->back()->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $data = $request->validate([
            'kode_anggota' => 'required|string|max:50|unique:members,kode_anggota,' . $member->id,
            'nama' => 'required|string|max:120',
            'kelas' => 'nullable|string|max:50',
            'telepon' => 'nullable|string|max:30',
            'alamat' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean'
        ]);

        $member->update($data);

        return redirect()->back()->with('success', 'Anggota berhasil diupdate.');
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return redirect()->back()->with('success', 'Anggota berhasil dihapus.');
    }

    public function toggle($id)
    {
        $member = Member::findOrFail($id);
        $member->update(['is_active' => !$member->is_active]);

        return redirect()->back()->with('success', 'Status anggota diperbarui.');
    }
}
