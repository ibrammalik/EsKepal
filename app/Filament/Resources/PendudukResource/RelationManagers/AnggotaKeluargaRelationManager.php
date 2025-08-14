<?php

namespace App\Filament\Resources\PendudukResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AnggotaKeluargaRelationManager extends RelationManager
{
    protected static string $relationship = 'anggotaKeluarga';
    protected static ?string $title = 'Anggota Keluarga';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nik')->label('NIK')->sortable(),
                Tables\Columns\TextColumn::make('nama')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('shdk')->label('SHDK'),
                Tables\Columns\TextColumn::make('jenis_kelamin')->label('JK'),
            ])
            ->paginated(false); // biar semua anggota muncul
    }
}
