<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessCard extends Model
{
    use HasFactory;
    protected $fillable = ['card_number', 'status'];
    protected $casts = [
        'status' => 'string',
    ];
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
    public function scopeAvailable($query)
    {
        return $query->where('status', 'tersedia');
    }
    public function scopeBorrowed($query)
    {
        return $query->where('status', 'dipinjam');
    }
    public function scopeLost($query)
    {
        return $query->where('status', 'hilang');
    }
}
