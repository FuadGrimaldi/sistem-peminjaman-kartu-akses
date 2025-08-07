@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Kartu Akses') }}</div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Card Number</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aksesCard as $card)
                                <tr>
                                    <td>{{ $aksesCard->firstItem() + $loop->index }}</td>
                                    <td>{{ $card->card_number }}</td>
                                    <td>{{ $card->status }}</td>
                                    <td>
                                        <!-- Add action buttons here -->
                                        
                                        <a href="{{ route('admin.kartu-akses.edit', $card->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('admin.kartu-akses.delete', $card->id) }}" method="POST" style="display:inline;">
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
                        {{ $aksesCard->links() }}
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.kartu-akses.create') }}" class="btn btn-success">Tambah Kartu Akses</a>
                </div>
            </div>
        </div>
    </div>
@endsection
