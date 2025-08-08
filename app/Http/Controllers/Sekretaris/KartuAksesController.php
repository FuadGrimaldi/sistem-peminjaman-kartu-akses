<?php

namespace App\Http\Controllers\Sekretaris;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccessCard; // Assuming you have a model for Kartu Akses

class KartuAksesController extends Controller
{
    public function index(Request $request){
        $query = AccessCard::query();
        if ($request->filled('search')) {
            $query->where('card_number', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $aksesCard = $query->paginate(10)->withQueryString(); // 10 data per halaman
        return view('sekretaris.kartu-akses', compact('aksesCard')); // Return the
    }
    public function create(){
        return view('sekretaris.kartu-akses-create'); // Return the view to create a new access card
    }
    public function store(Request $request){
        // Validate the request data
        $request->validate([
            'card_number' => 'required|unique:access_cards,card_number',
            'status' => 'required|in:tersedia,dipinjam,hilang',
        ]);

        // Create a new access card
        AccessCard::create($request->all());

        // Redirect back to the index with a success message
        return redirect()->route('sekre.kartu-akses')->with('success', 'Kartu Akses berhasil dibuat.');
    }
    public function edit($id){
        $kartuAkses = AccessCard::findOrFail($id); // Find the access card by ID
        return view('sekretaris.kartu-akses-edit', ['kartuAkses' => $kartuAkses]); // Return the edit view
    }
    public function update(Request $request, $id){
        // Validate the request data
        $request->validate([
            'card_number' => 'required|unique:access_cards,card_number,' . $id,
            'status' => 'required|in:tersedia,dipinjam,hilang',
        ]);
        // Find the access card by ID and update it
        $aksesCard = AccessCard::findOrFail($id);
        $aksesCard->update($request->all());
        // Redirect back to the index with a success message
        return redirect()->route('sekre.kartu-akses')->with('success', 'KartuAkses berhasil diperbarui.');
    }

    public function destroy($id){
        $aksesCard = AccessCard::findOrFail($id); // Find the access card by ID
        $aksesCard->delete(); // Delete the access card
        // Redirect back to the index with a success message
        return redirect()->route('sekre.kartu-akses')->with('success', 'Kartu Akses berhasil dihapus.');
    }
}
