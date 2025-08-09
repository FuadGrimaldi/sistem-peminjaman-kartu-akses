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
                
                <select name="jabatan" id="jabatan" class="form-control" required>
                    <option value="">-- Pilih Jabatan --</option>
                    <option>ACCOUNT MANAGER</option>
                    <option>ACCOUNT MANAGER 1</option>
                    <option>ACCOUNT MANAGER 2</option>
                    <option>ADMIN</option>
                    <option>ADMIN SUPPORT</option>
                    <option>AMEX</option>
                    <option>ANGGOTA SECURITY POS JAGA</option>
                    <option>CLEANER</option>
                    <option>DEFA</option>
                    <option>Digital Creative Witel</option>
                    <option>ENGINEER QC &amp; MANAGED SERVICE</option>
                    <option>EOS</option>
                    <option>EOS SDA AREA YOGYAKARTA</option>
                    <option>GM WITEL YOGYAKARTA JATENG SELATAN</option>
                    <option>indibiz solution expert ISE</option>
                    <option>Inputer</option>
                    <option>JR OFFICER OPERTION DAN PROJECT DELIVE</option>
                    <option>KAPOK SECURITY POS JAGA</option>
                    <option>KOORDINATOR ME &amp; SIPIL</option>
                    <option>KOORDINATOR SECURITY &amp; PARKING</option>
                    <option>KP</option>
                    <option>MANAGER AREA</option>
                    <option>MGR GOVERNMENT SERVICE</option>
                    <option>MGR LARGE ENTERPRISE SERVICE AREA V</option>
                    <option>MGR PERFORMANCE, RISK &amp; QOS</option>
                    <option>MGR SHARED SERVICE &amp; GENERAL SUPPORT</option>
                    <option>MGR WITEL BUSINESS SERVICE</option>
                    <option>OFF 1 COLLECTION &amp; DEBT MGT</option>
                    <option>OFF 1 QUALITY OF SALES &amp; REVAS</option>
                    <option>OFF 1 SALES &amp; TEAM SUPPORT</option>
                    <option>OFF 1 SALES ENGINEER</option>
                    <option>OFF 2 FINANCE &amp; HC</option>
                    <option>OFF 2 ORDER MANAGEMENT</option>
                    <option>OFF 3 PERFORMANCE &amp; RISK MANAGEMEN</option>
                    <option>OFF 3 SALES OPERATION</option>
                    <option>Sekertaris GM</option>
                    <option>SENIOR ACCOUNT MANAGER</option>
                    <option>TEKNISI ME</option>
                    <option>TERRITORY REP OFFICER</option>
                    <option>Blanks</option>
                </select>
        </div>

        <div class="mb-3">
            <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
            <input type="date" class="form-control" id="tanggal_peminjaman" name="tanggal_peminjaman" required>
        </div>
        <div class="mb-3">
            <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian <span style="color: blue;">(Dapat di kosongkan dengan default durasi 258 hari)</span></label>
            <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian">
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
            <label for="lampiran" class="form-label">Lampiran pengajuan (PDF)</label>
            <input type="file" class="form-control" id="lampiran" name="lampiran" accept="application/pdf">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
