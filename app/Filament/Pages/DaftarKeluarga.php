<?php

namespace App\Filament\Pages;

use App\Models\Penduduk;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;

class DaftarKeluarga extends Page implements HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static string $view = 'filament.pages.daftar-keluarga';
    protected static ?string $navigationGroup = 'Kependudukan';
    protected static ?string $title = 'Daftar Keluarga';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Penduduk::query()
                    ->select('no_kk')
                    ->selectRaw('COUNT(*) as anggota_count')
                    ->whereNotNull('no_kk')
                    ->groupBy('no_kk')
                    ->orderByDesc('anggota_count')
            )
            ->columns([
                TextColumn::make('no_kk')->label('No KK'),
                TextColumn::make('anggota_count')->label('Jumlah Anggota')->sortable(),
            ])
            ->actions([
                Action::make('testModal')
                    ->label('Test Modal')
                    ->modalHeading('Hello from Modal')
                    ->modalSubmitActionLabel('OK')
                    ->form([
                        TextInput::make('message')
                            ->label('Type something')
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        // Just log or dump
                        info('Modal submitted: ' . $data['message']);
                    }),
            ])
            ->paginated(true);
    }

    protected function anggotaInfolist(string $noKk): Infolist
    {
        $anggota = Penduduk::where('no_kk', $noKk)->get();

        return Infolist::make()
            ->schema([
                RepeatableEntry::make('anggota')
                    ->label('')
                    ->schema([
                        TextEntry::make('nama')->label('Nama'),
                        TextEntry::make('nik')->label('NIK'),
                        TextEntry::make('jenis_kelamin')->label('Jenis Kelamin'),
                        TextEntry::make('tanggal_lahir')->label('Tanggal Lahir'),
                    ])
                    ->columns(4)
                    ->default($anggota->toArray()),
            ]);
    }

    public function getTableRecordKey(mixed $record): string
    {
        return $record->no_kk;
    }
}
