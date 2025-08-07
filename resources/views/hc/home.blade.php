@extends('layouts.hc')


@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h6 class="h5 mb-0 text-gray-800"></h6>
        <span class="text-muted">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
    </div>

    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card shadow mb-4">
                
                <div class="card-body">
                    <ul class=" list-group list-group-flush">
                        <h6 class="list-group-item font-weight-bold text-primary">Ringkasan Peminjaman</h6>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Semua Peminjaman
                            <span class="badge bg-primary rounded-pill fs-6">{{ $totalPeminjaman }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Peminjaman Selesai
                            <span class="badge bg-success rounded-pill fs-6">{{ $completedPeminjaman }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Peminjaman Aktif (Dipinjam)
                            <span class="badge bg-warning text-dark rounded-pill fs-6">{{ $borrowedAccessCards }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Hilang
                            <span class="badge bg-danger text-dark rounded-pill fs-6">{{ $goneAccessCard }}</span>
                        </li>
                        
                    </ul>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="list-group list-group-flush">
                   
                        <h6 class="list-group-item font-weight-bold text-primary">Akses Cepat</h6>
                    <a href="{{ route('hc.peminjaman.create') }}" class=" list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Buat Peminjaman Baru <i class="bi bi-journal-plus text-primary"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-5 mb-4">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="card-header-custom">
                        <h6 class="font-weight-bold text-primary" >Penggunaan Kartu</h6>
                    </div>
                    <h4 class="mt-4 small font-weight-bold">Kartu Dipinjam <span class="float-end">{{ $borrowedAccessCards }} dari {{ $totalAccessCards }}</span></h4>
                    @php
                        $percentage = $totalAccessCards > 0 ? ($borrowedAccessCards / $totalAccessCards) * 100 : 0;
                    @endphp
                    
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="card-header-custom">
                        <h6 class="font-weight-bold text-primary">History Peminjaman</h6>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestPeminjaman as $item)
                                    <tr>
                                        <td>{{ $item->nama_peminjam }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d M Y') }}</td>
                                        <td>
                                            @if($item->status == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($item->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($item->status == 'rejected')
                                                <span class="badge bg-danger">Hilang</span>
                                            @else
                                                <span class="badge bg-primary">{{ ucfirst($item->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data peminjaman.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</div>
@endsection