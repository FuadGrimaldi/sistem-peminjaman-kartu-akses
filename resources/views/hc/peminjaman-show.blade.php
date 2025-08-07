@extends('layouts.hc')

@section('content')
<div class="container">
    <h2 style="margin-top: 1rem;">Detail Peminjaman</h2>

    <div class="row">
        <!-- Main Information Card -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                        <h5 class="mb-0">Informasi Peminjaman</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Personal Information -->
                        <div class="col-12">
                            <h6 class="text-muted mb-3 fw-bold">
                                <i class="bi bi-person-circle me-2"></i>Informasi Peminjam
                            </h6>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Nama Peminjam</label>
                                <div class="info-value">{{ $peminjaman->nama_peminjam }}</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Jabatan</label>
                                <div class="info-value">{{ $peminjaman->jabatan }}</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">NIK</label>
                                <div class="info-value">{{ $peminjaman->nik }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Mitra</label>
                                <div class="info-value">{{ $peminjaman->mitra }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Unit</label>
                                <div class="info-value">{{ $peminjaman->unit }}</div>
                            </div>
                        </div>

                        <!-- Loan Information -->
                        <div class="col-12 mt-5">
                            <h6 class="text-muted mb-3 fw-bold">
                                <i class="bi bi-calendar-event me-2"></i>Informasi Peminjaman
                            </h6>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Tanggal Peminjaman</label>
                                <div class="info-value">
                                    <i class="bi bi-calendar-check text-success me-2"></i>
                                    {{ $peminjaman->tanggal_peminjaman->toDateString() }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Tanggal Pengembalian</label>
                                <div class="info-value">
                                    <i class="bi bi-calendar-x text-warning me-2"></i>
                                    {{ $peminjaman->tanggal_pengembalian ? $peminjaman->tanggal_pengembalian->toDateString() : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Durasi Peminjaman</label>
                                <div class="info-value">
                                    <i class="bi bi-calendar-x text-warning me-2"></i>
                                    {{ $peminjaman->durasi}}
                                </div>
                            </div>
                        </div>

                        <!-- Asset Information -->
                        <div class="col-12 mt-5">
                            <h6 class="text-muted mb-3 fw-bold">
                                <i class="bi bi-credit-card me-2"></i>Informasi Aset
                            </h6>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Access Card</label>
                                <div class="info-value">
                                    @if($peminjaman->accessCard)
                                        <span class="badge bg-info fs-6 px-3 py-2">
                                            <i class="bi bi-credit-card-2-front me-1"></i>
                                            {{ $peminjaman->accessCard->card_number }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Document -->
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Lampiran</label>
                                <div class="info-value">
                                    @if($peminjaman->lampiran)
                                        <a href="{{ asset('storage/' . $peminjaman->lampiran) }}" target="_blank" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-file-earmark-text me-1"></i>
                                            Lihat Lampiran
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak ada lampiran</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status & Additional Info -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-flag-fill me-2"></i>Status Peminjaman
                    </h6>
                </div>
                <div class="card-body text-center p-4">
                    @if($peminjaman->status == 'pending')
                        <div class="status-badge pending">
                            <i class="bi bi-clock-fill fs-1 mb-3"></i>
                            <h5 class="mb-2">Pending</h5>
                            <p class="text-muted mb-0">Menunggu persetujuan</p>
                        </div>
                    @elseif($peminjaman->status == 'approved')
                        <div class="status-badge approved">
                            <i class="bi bi-check-circle-fill fs-1 mb-3"></i>
                            <h5 class="mb-2">Approved</h5>
                            <p class="text-muted mb-0">Peminjaman disetujui</p>
                        </div>
                    @elseif($peminjaman->status == 'rejected')
                        <div class="status-badge rejected">
                            <i class="bi bi-x-circle-fill fs-1 mb-3"></i>
                            <h5 class="mb-2">Rejected</h5>
                            <p class="text-muted mb-0">Peminjaman ditolak</p>
                        </div>
                    @elseif($peminjaman->status == 'completed')
                        <div class="status-badge completed">
                            <i class="bi bi-check2-all fs-1 mb-3"></i>
                            <h5 class="mb-2">Completed</h5>
                            <p class="text-muted mb-0">Peminjaman selesai</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Approval Information -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-people-fill me-2"></i>Informasi Persetujuan
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="approval-item mb-3">
                        <label class="approval-label">Requested By</label>
                        <div class="approval-value">
                            @if($peminjaman->requestedBy)
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                        {{ substr($peminjaman->requestedBy->name, 0, 1) }}
                                    </div>
                                    <span>{{ $peminjaman->requestedBy->name }}</span>
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="approval-item">
                        <label class="approval-label">Approved By</label>
                        <div class="approval-value">
                            @if($peminjaman->approvedBy)
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                        {{ substr($peminjaman->approvedBy->name, 0, 1) }}
                                    </div>
                                    <span>{{ $peminjaman->approvedBy->name }}</span>
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Card -->
            @if($peminjaman->catatan_admin)
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-warning bg-opacity-10 py-3">
                        <h6 class="mb-0 fw-bold" style="color: #212529;">
                            <i class="bi bi-sticky-fill me-2"></i>Catatan Admin
                        </h6>
                    </div>
                    <div >
                        <div class="alert alert-warning border-0 mb-0" style="color: #212529;" role="alert">
                            <i class="bi bi-info-circle me-2"></i>
                            {{ $peminjaman->catatan_admin }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <a href="{{ route('hc.peminjaman') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<style>
.info-item {
    background: #e9ecf0ff;
    padding: 1rem;
    border-radius: 0.rem;
    border-left: 4px solid #1c5a9cff;
    height: 100%;
}

.info-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #0069c5ff;
    margin-bottom: 0.5rem;
    display: block;
}

.info-value {
    font-size: 1rem;
    color: #212529;
    font-weight: 500;
}

.status-badge.pending {
    color: #856404;
}

.status-badge.approved {
    color: #155724;
}

.status-badge.rejected {
    color: #721c24;
}

.status-badge.completed {
    color: #004085;
}

.status-badge i {
    opacity: 0.7;
}

.approval-item {
    padding: 0.75rem 0;
    border-bottom: 1px solid #e9ecef;
}

.approval-item:last-child {
    border-bottom: none;
}

.approval-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #6c757d;
    margin-bottom: 0.5rem;
    display: block;
}

.approval-value {
    font-size: 0.95rem;
    color: #212529;
}

.avatar-sm {
    width: 2rem;
    height: 2rem;
    font-size: 0.875rem;
    font-weight: 600;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    font-weight: bold;
    color: #6c757d;
}

@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }
    
    .info-item {
        margin-bottom: 1rem;
    }
}
</style>
@endsection