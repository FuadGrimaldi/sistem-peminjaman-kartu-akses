@extends('layouts.admin')


@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h6 class="h5 mb-0 text-gray-800"></h6>
        <span class="text-muted">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="small font-weight-bold">Kartu Dipinjam <span class="float-end">{{ $borrowedAccessCards }} dari {{ $totalAccessCards }}</span></h4>
                    @php
                        $percentage = $totalAccessCards > 0 ? ($borrowedAccessCards / $totalAccessCards) * 100 : 0;
                    @endphp
                    <!-- <div class="progress mb-4" style="height: 20px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> -->
                    
                    <div class="progress-label mt-4">
                        <span><i class="bi bi-circle-fill text-warning"></i> Dipinjam</span>
                        <span>{{ $borrowedAccessCards }} Kartu</span>
                    </div>
                    <hr class="my-1">
                    <div class="progress-label">
                        <span><i class="bi bi-circle-fill text-info"></i> Tersedia</span>
                        <span>{{ $availableAccessCards }} Kartu</span>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs fs-bold text-primary text-uppercase mb-1">Total Pengguna</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                    </div>
                    <div class="stats-icon icon-bg-primary">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Kartu Akses</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAccessCards }}</div>
                    </div>
                    <div class="stats-icon icon-bg-success">
                        <i class="bi bi-credit-card-2-front"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Peminjaman</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPeminjaman }}</div>
                    </div>
                     <div class="stats-icon icon-bg-warning">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="row">
    <!-- Ringkasan Peminjaman -->
    <div class="col-xl-6 col-md-6">
        <div class="card shadow mb-4">
            <div class="card-body">
                <ul class="list-group list-group-flush">
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
    </div>

    <!-- Akses Cepat -->
    <div class="col-xl-6 col-md-6">
        <div class="card shadow mb-4">
            <div class="list-group list-group-flush">
                <h6 class="list-group-item font-weight-bold text-primary">Akses Cepat</h6>
                <a href="{{-- route('admin.peminjaman.create') --}}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    Buat Peminjaman Baru <i class="bi bi-journal-plus text-primary"></i>
                </a>
                <a href="{{-- route('admin.users.create') --}}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    Tambah Pengguna Baru <i class="bi bi-person-plus text-success"></i>
                </a>
                <a href="{{-- route('admin.access_cards.create') --}}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    Daftarkan Kartu Baru <i class="bi bi-credit-card text-info"></i>
                </a>
            </div>
        </div>
    </div>
</div>

    <div class="row">
        <div class="card m-2 shadow mb-4">
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
                                    <th>Tanggal Pengembalian</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestPeminjaman as $item)
                                    <tr>
                                        <td><a href="{{route('admin.peminjaman.show', $item->id)}}">{{ $item->nama_peminjam }}</a></td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d M Y') }}</td>
                                        <td>
                                            @if($item->tanggal_pengembalian)
                                                {{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d M Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->accessCard && $item->accessCard->status == 'hilang')
                                                <span class="badge bg-danger">Hilang</span>
                                            @elseif($item->status == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($item->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($item->status == 'rejected')
                                                <span class="badge bg-danger">Ditolak</span>
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
        <div class="card shadow mb-4">
            <div class="card-body">
                <h6 class="font-weight-bold text-primary">Statistik Peminjaman per Bulan</h6>
                <canvas id="peminjamanChart" height="120" 
                        data-months="{{ json_encode($months) }}"
                        data-approved="{{ json_encode($approvedData) }}"
                        data-pending="{{ json_encode($pendingData) }}"
                        data-rejected="{{ json_encode($rejectedData) }}"
                        data-completed="{{ json_encode($completedData) }}">
                </canvas>
            </div>
        </div>
    </div>

    
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const canvas = document.getElementById('peminjamanChart');
        const labels = JSON.parse(canvas.dataset.months);
        const approvedData = JSON.parse(canvas.dataset.approved);
        const pendingData = JSON.parse(canvas.dataset.pending);
        const rejectedData = JSON.parse(canvas.dataset.rejected);
        const completedData = JSON.parse(canvas.dataset.completed);

        const ctx = canvas.getContext('2d');
        new Chart(ctx, {
            type: 'line', // ubah jadi line chart
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Approved',
                        data: approvedData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.4, // bikin garis melengkung
                    },
                    {
                        label: 'Pending',
                        data: pendingData,
                        borderColor: 'rgba(255, 206, 86, 1)',
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        fill: true,
                        tension: 0.4,
                    },
                    {
                        label: 'Rejected',
                        data: rejectedData,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: true,
                        tension: 0.4,
                    },
                    {
                        label: 'Completed',
                        data: completedData,
                        borderColor: 'rgba(99, 255, 122, 1)',
                        backgroundColor: 'rgba(118, 186, 140, 0.2)',
                        fill: true,
                        tension: 0.4,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@endpush
