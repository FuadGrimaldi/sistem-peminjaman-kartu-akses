@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center">
    <div class="card shadow-lg border-0 p-4" style="max-width: 500px; width: 100%;">
        <div class="text-center mb-4">
            <img src="{{ asset('assets/logo/patterns.svg') }}" alt="Aset Kartu" class="img-fluid" width="100">
            <h4 class="mt-3 fw-bold">Manajemen Aset Kartu</h4>
            <small class="text-muted">Silakan login untuk melanjutkan</small>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    name="password" required>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="remember" 
                    {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-danger">Login</button>
            </div>

            @if (Route::has('password.request'))
                <div class="text-center">
                    <a class="small text-decoration-none" href="{{ route('password.request') }}">
                        Forgot Your Password?
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
