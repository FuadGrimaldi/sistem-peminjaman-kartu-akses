@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Status Peminjaman') }}</div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Peminjam</th>
                                <th>Jabatan</th>
                                <th>Lampiran</th>
                                <th>Tgl Peminjaman</th>
                                <th>Durasi (bulan)</th>
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
                                                <span class="badge bg-danger">Hilang</span>
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
