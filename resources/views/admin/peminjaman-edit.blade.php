@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 style="margin-top: 1rem;">Edit Peminjaman</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.peminjaman.update', $peminjaman->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
            <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" value="{{ $peminjaman->nama_peminjam }}" required>
        </div>

        <div class="mb-3">
            <label for="nik" class="form-label">NIK</label>
            <input type="text" class="form-control" id="nik" name="nik" value="{{ $peminjaman->nik }}" required>
        </div>
        <div class="mb-3">
            <label for="mitra" class="form-label">Mitra</label>
            <select class="form-select" id="mitra" name="mitra" required>
                <option value="">-- Pilih Mitra --</option>
                @foreach(['Informedia', 'GSD', 'Telkom', 'ISH', 'Magang', 'PiNS'] as $mitra)
                    <option value="{{ $mitra }}" {{ $peminjaman->mitra == $mitra ? 'selected' : '' }}>{{ $mitra }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="unit" class="form-label">Unit</label>
            <select class="form-select" id="unit" name="unit" required>
                <option value="">-- Pilih Unit --</option>
                @foreach(['BS', 'ES', 'GM', 'GOV', 'GSD', 'HOTDA', 'Magang BS', 'Magang ES', 'Magang GOV', 'PRQ', 'RSO', 'RWS', 'SFA', 'SSGS', 'Blanks'] as $unit)
                    <option value="{{ $unit }}" {{ $peminjaman->unit == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $peminjaman->jabatan }}" required>
        </div>

        <div class="mb-3">
            <label for="durasi" class="form-label">Durasi <span style="color: blue;">(Dapat dikosongkan)</span></label>
            <input type="number" class="form-control" id="durasi" name="durasi" value="{{ $peminjaman->durasi }}">
        </div>

        <div class="mb-3">
            <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
            <input type="date" class="form-control" id="tanggal_peminjaman" name="tanggal_peminjaman" value="{{ $peminjaman->tanggal_peminjaman->toDateString() }}" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian <span style="color: blue;">(Dapat dikosongkan)</span></label>
            <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" value="{{ $peminjaman->tanggal_pengembalian ? $peminjaman->tanggal_pengembalian->toDateString() : '' }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                @foreach(['pending', 'approved', 'rejected', 'completed'] as $status)
                
                    <option value="{{ $status }}" {{ $peminjaman->status == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
    <label for="access_card_id" class="form-label">Access Card</label>
    <select class="form-select" id="access_card_id" name="access_card_id" required>
        {{-- Kartu yang sedang dipakai tampil dulu --}}
        @if($peminjaman->accessCard)
            <option value="{{ $peminjaman->accessCard->id }}" selected>
                {{ $peminjaman->accessCard->card_number }} (Sedang Dipakai)
            </option>
        @endif
        {{-- Daftar kartu lain yang tersedia --}}
        @foreach($accessCards as $card)
            @if(!$peminjaman->accessCard || $card->id != $peminjaman->accessCard->id)
                <option value="{{ $card->id }}">
                    {{ $card->card_number }}
                </option>
            @endif
        @endforeach
    </select>
</div>


        <div class="mb-3">
            <label for="requested_by_id" class="form-label">Request By</label>
            <select class="form-select" id="requested_by_id" name="requested_by_id" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $peminjaman->requested_by_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="lampiran" class="form-label">Lampiran (PDF)</label>
            @if($peminjaman->lampiran)
                <p><a href="{{ asset('storage/' . $peminjaman->lampiran) }}" target="_blank">Lihat Lampiran</a></p>
            @endif
            <input type="file" class="form-control" id="lampiran" name="lampiran" accept="application/pdf">
            <small class="text-muted">Kosongkan jika tidak ingin mengganti.</small>
        </div>

        <div class="mb-3">
            <label for="catatan_admin" class="form-label">Catatan Admin</label>
            <textarea class="form-control" id="catatan_admin" name="catatan_admin" rows="3">{{ $peminjaman->catatan_admin }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
