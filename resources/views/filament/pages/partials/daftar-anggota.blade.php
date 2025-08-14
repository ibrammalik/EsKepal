<table class="w-full text-sm text-left border">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 border">Nama</th>
            <th class="px-4 py-2 border">NIK</th>
            <th class="px-4 py-2 border">Jenis Kelamin</th>
            <th class="px-4 py-2 border">Tanggal Lahir</th>
        </tr>
    </thead>
    <tbody>
        @forelse($anggota as $a)
            <tr>
                <td class="px-4 py-2 border">{{ $a->nama }}</td>
                <td class="px-4 py-2 border">{{ $a->nik }}</td>
                <td class="px-4 py-2 border">{{ $a->jenis_kelamin }}</td>
                <td class="px-4 py-2 border">{{ $a->tanggal_lahir }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="px-4 py-2 text-center border">
                    Tidak ada anggota keluarga.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
