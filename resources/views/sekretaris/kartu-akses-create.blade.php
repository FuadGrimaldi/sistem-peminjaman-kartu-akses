@extends('layouts.sekre')

@section('content')
<div class="container mt-4">
    <h2>Buat Kartu Akses Baru</h2>
    <form action="{{ route('sekre.kartu-akses.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="card_number" class="form-label">Nomor Kartu</label>
            <input type="text" class="form-control" id="card_number" name="card_number" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="tersedia">Tersedia</option>
                <option value="dipinjam">Dipinjam</option>
                <option value="hilang">Hilang</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
