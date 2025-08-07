@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit User</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Role</label>
            <select class="form-select" id="type" name="type" required>
                <option value="0" {{ $user->getRawOriginal('type') == 0 ? 'selected' : '' }}>User</option>
                <option value="1" {{ $user->getRawOriginal('type') == 1 ? 'selected' : '' }}>Admin</option>
                <option value="2" {{ $user->getRawOriginal('type') == 2 ? 'selected' : '' }}>Manager</option>
                <option value="3" {{ $user->getRawOriginal('type') == 3 ? 'selected' : '' }}>HC</option>
                <option value="4" {{ $user->getRawOriginal('type') == 4 ? 'selected' : '' }}>Sekretaris</option>

            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
