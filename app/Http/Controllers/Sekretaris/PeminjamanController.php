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
    public function index()
    {
        
        $peminjaman = Peminjaman::orderBy('created_at', 'desc')->paginate(10);
        return view('sekretaris.peminjaman', ['peminjaman' => $peminjaman]); // Return the view with peminjaman data
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $accessCards = AccessCard::all();
        $users = User::where('type', 2)->get(); // ambil user HC (misal ada role)
        return view('sekretaris.peminjaman-show', compact('peminjaman', 'accessCards', 'users'));
    }

    public function ShowPengembalianHilang($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $accessCards = AccessCard::findOrFail($peminjaman->access_card_id);
        $users = User::findOrFail($peminjaman->requested_by_id); // ambil user HC (misal ada role)
        return view('sekretaris.peminjaman-pengembalian-hilang', compact('peminjaman', 'accessCards', 'users'));
    }
    
    public function updateStatusPengembalianHilang(Request $request, $id)
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
        $peminjaman->update($data);
        if ($data['status'] === 'approved') {
            // If the status is approved, update the access card status
            AccessCard::where('id', $data['access_card_id'])->update(['status' => 'dipinjam']);
        } elseif ($data['status'] === 'completed') {
            // If the status is completed, update the access card status to available
            AccessCard::where('id', $data['access_card_id'])->update(['status' => 'tersedia']);
        } elseif ($data['status'] === 'rejected') {
            // If the status is rejected, set the access card status to available
            AccessCard::where('id', $data['access_card_id'])->update(['status' => 'tersedia']);
        }
        else {
            // If not approved, set the access card status to available
            AccessCard::where('id', $data['access_card_id'])->update(['status' => 'tersedia']);
        }
        // Redirect back to the index with a success message
        return redirect()->route('sekre.peminjaman')->with('success', 'Peminjaman berhasil dibuat.');
    }

}
