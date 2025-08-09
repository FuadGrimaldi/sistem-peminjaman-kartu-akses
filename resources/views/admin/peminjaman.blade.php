@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Status Peminjaman') }}</div>
                <form method="GET" action="{{ route('admin.peminjaman') }}">
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
                            <a href="{{ route('admin.peminjaman') }}" class="btn btn-secondary">Reset</a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.peminjaman.export', request()->all()) }}" class="btn text-white bg-success">
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
                                        <a href="{{route('admin.peminjaman.edit', $pinjam->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="{{route('admin.peminjaman.show', $pinjam->id)}}" class="btn btn-secondary btn-sm">View</a>
                                        <form action="{{ route('admin.peminjaman.delete', $pinjam->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kartu akses ini?')">Delete</button>
                                        </form>
                                     
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
                    <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-success">Tambah Peminjaman</a>
                </div>
            </div>
        </div>
    </div>
@endsection
