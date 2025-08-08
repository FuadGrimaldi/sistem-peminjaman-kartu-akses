@extends('layouts.sekre')

@section('content')
<div class="container">
    <h2 style="margin-top: 1rem;">Approval Peminjaman</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sekre.peminjaman.update-status', $peminjaman->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="status" class="form-label">Status Peminjaman</label>
            <select class="form-select" id="status" name="status" required>
                @foreach(['approved', 'rejected'] as $status)
                    <option value="{{ $status }}" {{ $peminjaman->status == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="access_card_id" class="form-label">Access Card</label>
            <select class="form-select" id="access_card_id" name="access_card_id" required>
                @foreach($accessCards as $card)
                    <option value="{{ $card->id }}" {{ $peminjaman->access_card_id == $card->id ? 'selected' : '' }}>
                        {{ $card->card_number }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="requested_by_id" class="form-label">Request By</label>
            <select class="form-select" id="requested_by_id" name="requested_by_id" required>
                <option value="{{ $users->id }}">{{ $users->name }}</option>
                
            </select>
        </div>


        <div class="mb-3">
            <label for="catatan_admin" class="form-label">Catatan Admin</label>
            <textarea class="form-control" id="catatan_admin" name="catatan_admin" rows="3">{{ $peminjaman->catatan_admin }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
