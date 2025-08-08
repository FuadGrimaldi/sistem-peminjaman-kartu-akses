@extends('layouts.app')

@section('title', 'Selamat Datang | Manajemen Aset Kartu')

@section('content')
<div id="landing-page">
    <div class="d-flex flex-column align-items-center justify-content-center text-center py-5" 
         style="min-height: 80vh; background-color: rgba(255, 255, 255, 0.7); border-radius: 12px;">
         
        <div class="mb-4">
            <img src="{{ asset('/assets/logo/Logo_Telkom_Indonesia_2013.png') }}" 
                 alt="Aset Kartu" 
                 class="img-fluid" 
                 style="width: 200px;">
        </div>

        <h2 class="display-5 fw-bold mb-3">Kelola Aset Kartu Perusahaan dengan Mudah</h2>
        <p class="lead text-muted mb-4">
            Aplikasi internal untuk mengatur peminjaman, pengembalian, dan inventarisasi aset kartu perusahaan.
        </p>

        @if (Route::has('login'))
            <div class="d-flex justify-content-center gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-danger btn-lg">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-danger btn-lg">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-danger btn-lg">Register</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</div>
@endsection
