@extends('layouts.hc')

@section('content')
<div class="container">
    <h2 style="margin-top: 1rem;">Tambah Peminjaman</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('hc.peminjaman.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
            <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" required>
        </div>
        
        <div class="mb-3">
            <label for="nik" class="form-label">NIK</label>
            <input type="text" class="form-control" id="nik" name="nik" required>
        </div>
        <div class="mb-3">
            <label for="mitra" class="form-label">Mitra</label>
            <select class="form-select" id="mitra" name="mitra" required>
                <option value="">-- Pilih Mitra --</option>
                <option value="Informedia">Informedia</option>
                <option value="GSD">GSD</option>
                <option value="Telkom">Telkom</option>
                <option value="ISH">ISH</option>
                <option value="Magang">Magang</option>
                <option value="PiNS">PiNS</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="unit" class="form-label">Unit</label>
            <select class="form-select" id="unit" name="unit" required>
                <option value="">-- Pilih Unit --</option>
                <option value="BS">BS</option>
                <option value="ES">ES</option>
                <option value="GM">GM</option>
                <option value="GOV">GOV</option>
                <option value="GSD">GSD</option>
                <option value="HOTDA">HOTDA</option>
                <option value="Magang BS">Magang BS</option>
                <option value="Magang ES">Magang ES</option>
                <option value="Magang GOV">Magang GOV</option>
                <option value="PRQ">PRQ</option>
                <option value="RSO">RSO</option>
                <option value="RWS">RWS</option>
                <option value="SFA">SFA</option>
                <option value="SSGS">SSGS</option>
                <option value="Blanks">Blanks</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" class="form-control" id="jabatan" name="jabatan" required>
        </div>

        <div class="mb-3">
            <label for="durasi" class="form-label">Durasi Peminjaman (Bulan) <span style="color: blue;">(Dapat dikosongkan)</span></label>
            <input type="number" class="form-control" id="durasi" name="durasi" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
            <input type="date" class="form-control" id="tanggal_peminjaman" name="tanggal_peminjaman" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <input type="text" class="form-control" id="status" name="status" value="pending" readonly>
        </div>
        
        <div class="mb-3">
            <label for="requested_by_id" class="form-label">Request By</label>
            <select class="form-select" id="requested_by_id" name="requested_by_id" required>
                <option value="{{ $users->id }}">{{ $users->name }}</option>
                
            </select>
        </div>

        <div class="mb-3">
            <label for="lampiran" class="form-label">Lampiran (PDF)</label>
            <input type="file" class="form-control" id="lampiran" name="lampiran" accept="application/pdf">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
