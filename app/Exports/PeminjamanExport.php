<?php

namespace App\Exports;

use App\Models\Peminjaman;
use App\Models\AccessCard;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PeminjamanExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = Peminjaman::query();
        $query->with(['requestedBy', 'approvedBy', 'accessCard']);

        if ($this->request->filled('search')) {
            $query->where('nama_peminjam', 'like', '%' . $this->request->search . '%');
        }

        if ($this->request->filled('unit')) {
            $query->where('unit', $this->request->unit);
        }

        if ($this->request->filled('mitra')) {
            $query->where('mitra', $this->request->mitra);
        }

        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        $data = $query->get();

        return view('admin.exports.peminjaman', [
            'peminjaman' => $data
        ]);
    }
}


