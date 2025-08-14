<div class="space-y-2">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b">
                <th class="text-left p-2">Nama</th>
                <th class="text-left p-2">SHDK</th>
                <th class="text-left p-2">Jenis Kelamin</th>
                <th class="text-left p-2">Tanggal Lahir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($anggota as $a)
                <tr class="border-b">
                    <td class="p-2">{{ $a->nama }}</td>
                    <td class="p-2">{{ $a->shdk }}</td>
                    <td class="p-2">{{ $a->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td class="p-2">{{ \Carbon\Carbon::parse($a->tanggal_lahir)->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
