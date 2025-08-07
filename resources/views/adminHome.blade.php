@extends('layouts.admin')


@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h6 class="h5 mb-0 text-gray-800"></h6>
        <span class="text-muted">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
    </div>

    <div class="row">
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
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Kartu Dipinjam</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $borrowedAccessCards }}</div>
                    </div>
                     <div class="stats-icon icon-bg-warning">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Peminjaman Terlambat</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $overdueLoans ?? 0 }}</div>
                    </div>
                     <div class="stats-icon icon-bg-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>
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
                    <a href="{{-- route('admin.peminjaman.create') --}}" class=" list-group-item list-group-item-action d-flex justify-content-between align-items-center">
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
                    <!-- <div class="progress mb-4" style="height: 20px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> -->
                    
                    <div class="progress-label mt-4">
                        <span><i class="bi bi-circle-fill text-warning"></i> Dipinjam</span>
                        <span>{{ $borrowedAccessCards }} Kartu</span>
                    </div>
                    <hr class="my-2">
                    <div class="progress-label">
                        <span><i class="bi bi-circle-fill text-info"></i> Tersedia</span>
                        <span>{{ $availableAccessCards }} Kartu</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</div>
@endsection