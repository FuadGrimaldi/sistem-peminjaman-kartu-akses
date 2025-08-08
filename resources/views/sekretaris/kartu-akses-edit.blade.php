@extends('layouts.sekre')

@section('content')
<div class="container mt-4">
    <h2>Buat Kartu Akses Baru</h2>
<form action="{{ route('sekre.kartu-akses.update', $kartuAkses->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="card_number" class="form-label">Nomor Kartu</label>
        <input type="text" class="form-control" id="card_number" name="card_number" value="{{ old('card_number', $kartuAkses->card_number) }}" required>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-control" id="status" name="status" required>
            <option value="tersedia" {{ old('status', $kartuAkses->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
            <option value="hilang" {{ old('status', $kartuAkses->status) == 'hilang' ? 'selected' : '' }}>Hilang</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
</form>
</div>
@endsection
