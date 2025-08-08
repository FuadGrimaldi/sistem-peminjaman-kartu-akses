<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Peminjam</th>
            <th>Jabatan</th>
            <th>NIK</th>
            <th>Durasi</th>
            <th>Lampiran</th>
            <th>Mitra</th>
            <th>Unit</th>
            <th>Tanggal Peminjaman</th>
            <th>Tanggal Pengembalian</th>
            <th>Status</th>
            <th>Requested By</th>
            <th>Approved By</th>
            <th>Access Card ID</th>
            <th>Catatan Admin</th>
            <th>Dibuat Pada</th>
            <th>Diperbarui Pada</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($peminjaman as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->nama_peminjam }}</td>
            <td>{{ $item->jabatan }}</td>
            <td>{{ $item->nik }}</td>
            <td>{{ $item->durasi }}</td>
            <td>{{ $item->lampiran }}</td>
            <td>{{ $item->mitra }}</td>
            <td>{{ $item->unit }}</td>
            <td>{{ $item->tanggal_peminjaman }}</td>
            <td>{{ $item->tanggal_pengembalian }}</td>
            <td>{{ $item->status }}</td>
            <td>{{ $item->requestedBy->name ?? '-' }}</td>
            <td>{{ $item->approvedBy->name ?? '-' }}</td>
            <td>{{ $item->accessCard->card_number ?? '-' }}</td>
            <td>{{ $item->catatan_admin }}</td>
            <td>{{ $item->created_at }}</td>
            <td>{{ $item->updated_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
