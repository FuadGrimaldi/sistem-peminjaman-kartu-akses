<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';

    protected $fillable = [
        'nama_peminjam',
        'jabatan',
        'nik',
        'durasi',
        'mitra',
        'unit',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'status',
        'requested_by_id',
        'approved_by_id',
        'access_card_id',
        'catatan_admin',
        'lampiran',
    ];

    protected $casts = [
        'tanggal_peminjaman' => 'date',
        'tanggal_pengembalian' => 'date',
        'status' => 'string',
    ];

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function accessCard()
    {
        return $this->belongsTo(AccessCard::class, 'access_card_id');
    }
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
    
}
