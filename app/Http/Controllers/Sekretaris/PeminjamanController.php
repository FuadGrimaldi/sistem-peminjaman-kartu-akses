<?php

namespace App\Http\Controllers\Sekretaris;

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

        return view('sekretaris.peminjaman', compact('peminjaman'));
    }


    public function show($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $accessCards = AccessCard::all();
        $users = User::where('type', 2)->get(); // ambil user HC (misal ada role)
        return view('sekretaris.peminjaman-show', compact('peminjaman', 'accessCards', 'users'));
    }

    public function ShowHilang($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $accessCards = AccessCard::findOrFail($peminjaman->access_card_id);
        $users = User::findOrFail($peminjaman->requested_by_id); // ambil user HC (misal ada role)
        return view('sekretaris.peminjaman-hilang', compact('peminjaman', 'accessCards', 'users'));
    }

    public function setujuiPengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'returned') {
            return redirect()->back()->with('error', 'Status peminjaman tidak valid untuk disetujui.');
        }
        AccessCard::where('id', $peminjaman->access_card_id)->update(['status' => 'tersedia']);
        $peminjaman->access_card_id = null;

        $peminjaman->update([
            'status' => 'completed',
            'tanggal_pengembalian' => now(), // jika ada kolom ini
            'access_card_id' => null,
        ]);

        return redirect()->route('sekre.peminjaman')->with('success', 'Pengembalian disetujui.');
    }

    
    public function updateStatusHilang(Request $request, $id)
{
    $request->validate([
        'access_card_id' => 'required|exists:access_cards,id',
        'tanggal_pengembalian' => 'nullable|date',
        'requested_by_id' => 'required|exists:users,id',
        'status' => 'required|in:pending,approved,rejected,completed',
    ]);

    $data = $request->all();
    $data['approved_by_id'] = Auth::id();
    

    $peminjaman = Peminjaman::findOrFail($id);

    // 🔽 Cek apakah checkbox "kartu hilang" dicentang
    if ($request->has('kartu_hilang') && $request->input('kartu_hilang')) {
        // Set status peminjaman jadi pending, dan kartu jadi hilang
        $peminjaman->update([
            'status' => 'pending',
            'access_card_id' => $request->access_card_id,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'requested_by_id' => $request->requested_by_id,
            'approved_by_id' => Auth::id(),
            'access_card_id' => null
        ]);
        AccessCard::where('id', $request->access_card_id)->update(['status' => 'hilang']);

    } else {
        // 🔽 Logic normal
        

        if ($data['status'] === 'approved') {
            AccessCard::where('id', $data['access_card_id'])->update(['status' => 'dipinjam']);
        } elseif ($data['status'] === 'completed') {
            AccessCard::where('id', $data['access_card_id'])->update(['status' => 'tersedia']);
            $data['access_card_id'] = null;
        } else {
            AccessCard::where('id', $data['access_card_id'])->update(['status' => 'tersedia']);
            $data['access_card_id'] = null;
        }
        $peminjaman->update($data);
    }

    return redirect()->route('sekre.peminjaman')->with('success', 'Peminjaman berhasil diperbarui.');
}

    public function approval($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $accessCards = AccessCard::where('status', 'tersedia')->get();
        $users = User::findOrFail($peminjaman->requested_by_id); // ambil user HC (misal ada role)
        return view('sekretaris.peminjaman-approval', compact('peminjaman', 'accessCards', 'users')); // Return the edit view with peminjaman data
    }

    public function updateStatus(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'access_card_id' => 'required|exists:access_cards,id',
            
            'requested_by_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,approved,rejected,completed',
            'catatan_admin' => 'nullable|string',
            
        ]);
        $data = $request->all();
        $data['approved_by_id'] = Auth::id();

        // Create Peminjaman Record
        $peminjaman = Peminjaman::findOrFail($id);
        if ($data['status'] === 'approved') {
            // If the status is approved, update the access card status
            AccessCard::where('id', $data['access_card_id'])->update(['status' => 'dipinjam']);
        } elseif ($data['status'] === 'rejected') {
            // If the status is rejected, set the access card status to available
            AccessCard::where('id', $data['access_card_id'])->update(['status' => 'tersedia']);
            $data['access_card_id'] = null; // Clear access card if rejected
        }
        else {
            // If not approved, set the access card status to available
            AccessCard::where('id', $data['access_card_id'])->update(['status' => 'tersedia']);
        }
        // Redirect back to the index with a success message
        $peminjaman->update($data);
        return redirect()->route('sekre.peminjaman')->with('success', 'Peminjaman berhasil dibuat.');
    }

}
