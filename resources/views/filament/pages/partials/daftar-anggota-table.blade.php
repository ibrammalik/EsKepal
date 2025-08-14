@php
    use Filament\Tables\Columns\TextColumn;
    use Filament\Tables\Table;

    $anggotaTable = app(Table::class)
        ->query(\App\Models\Penduduk::where('no_kk', $anggota->first()->no_kk))
        ->columns([
            TextColumn::make('nik')->label('NIK'),
            TextColumn::make('nama')->label('Nama'),
            TextColumn::make('jenis_kelamin')->label('Jenis Kelamin'),
            TextColumn::make('tanggal_lahir')->label('Tanggal Lahir'),
        ])
        ->paginated(false);
@endphp

{!! $anggotaTable->render() !!}
