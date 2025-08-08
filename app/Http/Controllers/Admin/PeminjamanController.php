<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman; // Assuming you have a model for Peminjaman
use App\Models\AccessCard; // Assuming you have a model for AccessCard
use App\Models\User; // Assuming you have a model for User
use Illuminate\Support\Facades\Auth;
use App\Exports\PeminjamanExport;
use Maatwebsite\Excel\Facades\Excel;

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

        return view('admin.peminjaman', compact('peminjaman'));
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $accessCards = AccessCard::all();
        $users = User::where('type', 2)->get(); // ambil user HC (misal ada role)
        return view('admin.peminjaman-show', compact('peminjaman', 'accessCards', 'users'));
    }

    public function create()
    {
        $accessCards = AccessCard::where('status', 'tersedia')->get();
        $users = User::where('type', 3)->get(); // ambil user HC (misal ada role)
        return view('admin.peminjaman-create', compact('accessCards', 'users'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'nama_peminjam' => 'required',
            'jabatan' => 'required',
            'nik' => 'required',
            'durasi' => 'nullable|integer',
            'mitra' => "required|in:Informedia,GSD,Telkom,ISH,Magang,PiNS",
            'unit' => 'required|in:BS,ES,GM,GOV,GSD,HOTDA,Magang BS,Magang ES,Magang GOV,PRQ,RSO,RWS,SFA,SSGS,Blanks',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'nullable|date|after_or_equal:tanggal_peminjaman',
            'status' => 'required|in:pending,approved,rejected,completed',
            'requested_by_id' => 'required|exists:users,id', // Assuming the user is the one approving
            'access_card_id' => 'required|exists:access_cards,id',
            'catatan_admin' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf|max:2048', // Assuming lampiran is a string, adjust as necessary
        ]);
        $data = $request->all();
        $data['approved_by_id'] = Auth::id();
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('lampiran_peminjaman', $filename, 'public');
            $data['lampiran'] = $path; // save relative path
        }

        // Create Peminjaman Record
        Peminjaman::create($data);
        if ($data['status'] === 'approved') {
            // If the status is approved, update the access card status
            AccessCard::where('id', $data['access_card_id'])->update(['status' => 'dipinjam']);
        } else {
            // If not approved, set the access card status to available
            AccessCard::where('id', $data['access_card_id'])->update(['status' => 'tersedia']);
        }
        // Redirect back to the index with a success message
        return redirect()->route('admin.peminjaman')->with('success', 'Peminjaman berhasil dibuat.');
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id); // Find the peminjaman by ID
        $accessCards = AccessCard::where('status', 'tersedia')->get();
        $users = User::where('type', 3)->get(); // ambil user HC (misal ada role)
        return view('admin.peminjaman-edit', compact('peminjaman', 'accessCards', 'users')); // Return the edit view with peminjaman data
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'nama_peminjam' => 'required',
            'jabatan' => 'required',
            'nik' => 'required',
            'durasi' => 'nullable|integer',
            'mitra' => "required|in:Informedia,GSD,Telkom,ISH,Magang,PiNS",
            'unit' => 'required|in:BS,ES,GM,GOV,GSD,HOTDA,Magang BS,Magang ES,Magang GOV,PRQ,RSO,RWS,SFA,SSGS,Blanks',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'nullable|date|after_or_equal:tanggal_peminjaman',
            'status' => 'required|in:pending,approved,rejected,completed',
            'requested_by_id' => 'required|exists:users,id', // Assuming the user is the one approving
            'access_card_id' => 'required|exists:access_cards,id',
            'catatan_admin' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf|max:2048', // Assuming lampiran is a string, adjust as necessary
        ]);
        $peminjaman = Peminjaman::findOrFail($id);
        $data = $request->all();
        $data['approved_by_id'] = Auth::id();
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('lampiran_peminjaman', $filename, 'public');
            $data['lampiran'] = $path; // save relative path
        } else {
            unset($data['lampiran']); // If no new file is uploaded, remove the key
        }
        // Cek apakah access_card_id berubah
    $oldCardId = $peminjaman->access_card_id;
    $newCardId = $request->input('access_card_id');

    // Update data peminjaman
    $peminjaman->update($data);

    // Update status kartu lama dan baru HANYA jika id-nya berubah
    if ($oldCardId != $newCardId) {
        // Set kartu lama menjadi tersedia
        if ($oldCardId) {
            AccessCard::where('id', $oldCardId)->update(['status' => 'tersedia']);
        }
        // Set kartu baru menjadi dipinjam
        AccessCard::where('id', $newCardId)->update(['status' => 'dipinjam']);
    } else {
        // Jika kartu tidak berubah, pastikan tetap dipinjam jika status approved
        if ($data['status'] === 'approved') {
            AccessCard::where('id', $newCardId)->update(['status' => 'dipinjam']);
        }
    }
        // Redirect back to the index with a success message
        return redirect()->route('admin.peminjaman')->with('success', 'Peminjaman berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id); // Find the peminjaman by ID
        $peminjaman->delete(); // Delete the peminjaman
        // Redirect back to the index with a success message
        return redirect()->route('admin.peminjaman')->with('success', 'Peminjaman berhasil dihapus.');
    }
    public function export(Request $request)
    {
        return Excel::download(new PeminjamanExport($request), 'data_peminjaman_access_card.xlsx');
    }
}
