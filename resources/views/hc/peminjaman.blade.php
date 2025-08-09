@extends('layouts.hc')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Status Peminjaman') }}</div>
                <form method="GET" action="{{ route('hc.peminjaman') }}">
                    <div class="row g-2 align-items-end m-4">
                        <div class="col-md-2">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari Nama Peminjam...">
                        </div>
                        <div class="col-md-2">
                            <select name="unit" class="form-select">
                                <option value="">-- Pilih Unit --</option>
                                @foreach(['BS','ES','GM','GOV','GSD','HOTDA','Magang BS','Magang ES','Magang GOV','PRQ','RSO','RWS','SFA','SSGS','Blanks'] as $unit)
                                    <option value="{{ $unit }}" {{ request('unit') == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="mitra" class="form-select">
                                <option value="">-- Pilih Mitra --</option>
                                @foreach(['Informedia', 'GSD', 'Telkom', 'ISH', 'Magang', 'PiNS'] as $mitra)
                                    <option value="{{ $mitra }}" {{ request('mitra') == $mitra ? 'selected' : '' }}>{{ $mitra }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select">
                                <option value="">-- Pilih Status --</option>
                                @foreach(['pending', 'approved', 'rejected', 'completed', 'returned'] as $status)
                                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('hc.peminjaman') }}" class="btn btn-secondary">Reset</a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('hc.peminjaman.export', request()->all()) }}" class="btn text-white bg-success">
                                Export Excel
                            </a>
                        </div>
                    </div>
                </form>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Peminjam</th>
                                <th>Jabatan</th>
                                <th>Lampiran</th>
                                <th>Tgl Peminjaman</th>
                                <th>Durasi (hari)</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peminjaman as $pinjam)
                                <tr>
                                    <td>{{ $peminjaman->firstItem() + $loop->index }}</td>
                                    <td>{{ $pinjam->nama_peminjam }}</td>
                                    <td>{{ $pinjam->jabatan }}</td>
                                    <td>
                                        @if($pinjam->lampiran)
                                            <a href="{{ asset('storage/' . $pinjam->lampiran) }}" target="_blank">Lihat Lampiran</a>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                    <td>{{ $pinjam->tanggal_peminjaman->toDateString() }}</td>
                                    <td>{{ $pinjam->durasi }}</td>
                                    <td>
                                        @if($pinjam->status == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($pinjam->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($pinjam->status == 'rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @elseif($pinjam->status == 'returned')
                                                <span class="badge bg-info">Proses Pengembalian</span>
                                            @else
                                                <span class="badge bg-primary">{{ ucfirst($pinjam->status) }}</span>
                                            @endif        
                                    </td>
                                    <td>
                                        <!-- Add action buttons here -->
                                        <a href="{{route('hc.peminjaman.show', $pinjam->id)}}" class="btn btn-secondary btn-sm">View</a>
                                        @if($pinjam->status == 'approved')
                                        <!-- Tombol Ajukan Pengembalian -->
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#returnModal{{ $pinjam->id }}">
                                            Ajukan Pengembalian
                                        </button>

                                        <div class="modal fade" id="returnModal{{ $pinjam->id }}" tabindex="-1" aria-labelledby="returnModalLabel{{ $pinjam->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('hc.peminjaman.return', $pinjam->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="returnModalLabel{{ $pinjam->id }}">Konfirmasi Pengembalian</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <p>Anda yakin ingin mengajukan pengembalian untuk <strong>{{ $pinjam->nama_peminjam }}</strong>?</p>
                                                        
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="checkbox" value="1" id="tanpaLampiran{{ $pinjam->id }}">
                                                            <label class="form-check-label" for="tanpaLampiran{{ $pinjam->id }}">
                                                                Ajukan tanpa lampiran
                                                            </label>
                                                        </div>

                                                        <div class="mb-3" id="lampiranContainer{{ $pinjam->id }}">
                                                            <label for="lampiran_pengembalian{{ $pinjam->id }}" class="form-label">Lampiran Pengembalian (PDF)</label>
                                                            <input type="file" name="lampiran" id="lampiran_pengembalian{{ $pinjam->id }}" class="form-control" accept="application/pdf">
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <small class="text-danger me-auto">
                                                            *Tanggal pengembalian akan otomatis diisi jika pengembalian sudah disetujui
                                                        </small>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Ajukan Pengembalian</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <script>
                                    document.getElementById('tanpaLampiran{{ $pinjam->id }}').addEventListener('change', function() {
                                        const fileInput = document.getElementById('lampiran_pengembalian{{ $pinjam->id }}');
                                        const container = document.getElementById('lampiranContainer{{ $pinjam->id }}');
                                        if (this.checked) {
                                            container.style.display = 'none';
                                            fileInput.value = '';
                                        } else {
                                            container.style.display = 'block';
                                        }
                                    });
                                    </script>


                                    @endif                                     
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $peminjaman->links() }}
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('hc.peminjaman.create') }}" class="btn btn-success">Tambah Peminjaman</a>
                </div>
            </div>
        </div>
    </div>
@endsection
