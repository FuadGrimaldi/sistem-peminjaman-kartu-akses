<?php

namespace App\Http\Controllers\Hc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman; // Assuming you have a model for Peminjaman
use App\Models\AccessCard; // Assuming you have a model for AccessCard
use App\Models\User; // Assuming you have a model for User
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::query();

        if ($request->filled('search')) {
            $query->where('nama_peminjam', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('unit')) {
            $query->where('unit', $request->unit);
        }

        if ($request->filled('mitra')) {
            $query->where('mitra', $request->mitra);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('hc.peminjaman', compact('peminjaman'));
    }


    public function show($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $accessCards = AccessCard::all();
        $users = User::where('type', 2)->get(); // ambil user HC (misal ada role)
        return view('hc.peminjaman-show', compact('peminjaman', 'accessCards', 'users'));
    }

    public function create()
    {
        $id = Auth::id();
        $users = User::findOrFail($id);
        $accessCards = AccessCard::where('status', 'tersedia')->get();
        return view('hc.peminjaman-create', compact('accessCards', 'users'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'nama_peminjam' => 'required',
            'jabatan' => 'required',
            'nik' => 'required',
            'durasi' => 'required',
            'mitra' => "required|in:Informedia,GSD,Telkom,ISH,Magang,PiNS",
            'unit' => 'required|in:BS,ES,GM,GOV,GSD,HOTDA,Magang BS,Magang ES,Magang GOV,PRQ,RSO,RWS,SFA,SSGS,Blanks',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'nullable|date|after_or_equal:tanggal_peminjaman',
            'status' => 'required|in:pending,approved,rejected,completed',
            'requested_by_id' => 'required|exists:users,id', // Assuming the user is the one approving
            'catatan_admin' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf|max:2048', // Assuming lampiran is a string, adjust as necessary
        ]);
        $data = $request->all();
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('lampiran_peminjaman', $filename, 'public');
            $data['lampiran'] = $path; // save relative path
        }

        // Create Peminjaman Record
        Peminjaman::create($data);
        // Redirect back to the index with a success message
        return redirect()->route('hc.peminjaman')->with('success', 'Peminjaman berhasil dibuat.');
    }

    public function ajukanPengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Pastikan hanya peminjaman yang diapprove bisa ajukan pengembalian
        if ($peminjaman->status !== 'approved') {
            return back()->with('error', 'Hanya peminjaman yang disetujui bisa diajukan untuk pengembalian.');
        }

        $peminjaman->status = 'returned';
        $peminjaman->save();

        return redirect()->route('hc.peminjaman')->with('success', 'Pengembalian berhasil diajukan.');
    }

}
