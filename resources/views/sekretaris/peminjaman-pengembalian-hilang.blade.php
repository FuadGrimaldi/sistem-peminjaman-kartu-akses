@extends('layouts.sekre')

@section('content')
<div class="container">
    <h2 style="margin-top: 1rem; margin-bottom: 2rem;">Pengembalian atau Hilang kartu</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sekre.peminjaman.update-status-pengembalian-hilang', $peminjaman->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="mb-3">
            <label for="nama_peminjam" class="form-label">Nama Peminjam </label>
            <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" value="{{ $peminjaman->nama_peminjam }}" readonly>
        </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status pinjaman</label>
        <select class="form-select" id="status" name="status" required>
            @foreach(['approved','completed'] as $status)
                <option value="{{ $status }}" {{ $peminjaman->status == $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </div>
    
    <div class="mb-3">
            <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian </label>
            <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian">
        </div>

    <div class="mb-3">
        <label for="access_card_id" class="form-label">Access Card</label>
        <select class="form-select" id="access_card_id" name="access_card_id" required>
            
                <option value="{{ $peminjaman->access_card_id }}" {{ $peminjaman->access_card_id == $accessCards->id ? 'selected' : '' }}>
                    {{ $accessCards->card_number }}
                </option>
        </select>
    </div>


    <div class="mb-3">
        <label for="requested_by_id" class="form-label">Request By</label>
        <select class="form-select" id="requested_by_id" name="requested_by_id" required>
            <option value="{{ $users->id }}">{{ $users->name }}</option>
        </select>
    </div>


    {{-- 🔽 Checkbox untuk hilang --}}
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" value="1" id="kartu_hilang" name="kartu_hilang">
        <label class="form-check-labe text-danger" for="kartu_hilang">
            Kartu Hilang
        </label>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>

</div>
@endsection
