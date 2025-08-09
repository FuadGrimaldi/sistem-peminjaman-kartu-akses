<?php

namespace App\Http\Controllers\Hc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman; // Assuming you have a model for Peminjaman
use App\Models\AccessCard; // Assuming you have a model for AccessCard
use App\Models\User; // Assuming you have a model for User
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'durasi' => 'nullable|integer', // Default durasi 258 hari  
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
        // Set default durasi if not provided and tanggal_pengembalian is not set
        if (!$request->filled('durasi') && !$request->filled('tanggal_pengembalian')) {
            $data['durasi'] = 258;
        }
        if ($request->filled('tanggal_peminjaman') && $request->filled('tanggal_pengembalian')) {
            $tanggalPeminjaman = \Carbon\Carbon::parse($request->input('tanggal_peminjaman'));
            $tanggalPengembalian = \Carbon\Carbon::parse($request->input('tanggal_pengembalian'));
            $data['durasi'] = $tanggalPeminjaman->diffInDays($tanggalPengembalian);
        }
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

    
    public function ajukanPengembalian(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'approved') {
            return back()->with('error', 'Hanya peminjaman yang disetujui bisa diajukan untuk pengembalian.');
        }

        // Validasi lampiran
        $request->validate([
            'lampiran' => 'nullable|file|mimes:pdf|max:2048',
        ]);
        if ($request->hasFile('lampiran')) {
        // hapus lampiran lama kalau ada

        // Hapus lampiran lama jika ada
            if ($peminjaman->lampiran && Storage::disk('public')->exists($peminjaman->lampiran)) {
                Storage::disk('public')->delete($peminjaman->lampiran);
            }
            $file = $request->file('lampiran');
            $filename = time().'_'.$file->getClientOriginalName();
            $path = $file->storeAs('lampiran_pengembalian', $filename, 'public');
            $peminjaman->lampiran = $path;
        }

        $peminjaman->status = 'returned';
        $peminjaman->save();

        return redirect()->route('hc.peminjaman')->with('success', 'Pengembalian berhasil diajukan dengan lampiran baru.');
    }

}
