<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendudukResource\Pages;
use App\Filament\Resources\PendudukResource\RelationManagers;
use App\Models\Penduduk;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PendudukResource extends Resource
{
    protected static ?string $model = Penduduk::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Kependudukan';
    protected static ?string $navigationLabel = 'Data Penduduk';
    protected static ?string $pluralModelLabel = 'Data Penduduk';
    protected static ?string $modelLabel = 'Penduduk';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Fieldset::make('Data Pribadi')->schema([
                TextInput::make('nik')
                    ->label('NIK')
                    ->numeric()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->extraAttributes(['class' => 'hide-number-arrows']),

                TextInput::make('nama')->label('Nama')->required(),

                Grid::make(2)->schema([
                    TextInput::make('no_kk')
                        ->label('Nomor Kartu Keluarga')
                        ->maxLength(16)
                        ->required()
                        ->numeric(),

                    Select::make('shdk')
                        ->label('Status Hubungan Dalam Keluarga (SHDK)')
                        ->options([
                            'Kepala Keluarga' => 'Kepala Keluarga',
                            'Suami' => 'Suami',
                            'Istri' => 'Istri',
                            'Anak' => 'Anak',
                            'Menantu' => 'Menantu',
                            'Orang Tua' => 'Orang Tua',
                            'Mertua' => 'Mertua',
                            'Pembantu' => 'Pembantu',
                            'Famili Lain' => 'Famili Lain',
                            'Lainnya' => 'Lainnya',
                        ])
                        ->required()
                        ->searchable(),
                ]),

                Grid::make(2)->schema([
                    TextInput::make('tempat_lahir')->label('Tempat Lahir')->required(),
                    DatePicker::make('tanggal_lahir')->label('Tanggal Lahir')->required(),
                ]),

                Textarea::make('alamat')->label('Alamat')->required()->columnSpanFull(),

                Grid::make(2)->schema([
                    Select::make('rw_id')
                        ->label('RW')
                        ->relationship('rw', 'nomor')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->reactive()
                        ->afterStateUpdated(fn(callable $set) => $set('rt_id', null)),

                    Select::make('rt_id')
                        ->label('RT')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->options(function (callable $get) {
                            $rwId = $get('rw_id');
                            return $rwId ? \App\Models\Rt::where('rw_id', $rwId)->pluck('nomor', 'id') : [];
                        }),
                ]),

                Grid::make(2)->schema([
                    Select::make('jenis_kelamin')
                        ->label('Jenis Kelamin')
                        ->options(['L' => 'Laki-laki', 'P' => 'Perempuan'])
                        ->required(),

                    Select::make('status_kependudukan_id')
                        ->label('Status Kependudukan')
                        ->relationship('statusKependudukan', 'name')
                        ->searchable()
                        ->preload(),
                ]),

                Grid::make(2)->schema([
                    Select::make('agama_id')
                        ->label('Agama')
                        ->relationship('agama', 'name')
                        ->searchable()
                        ->preload(),

                    Select::make('status_perkawinan_id')
                        ->label('Status Perkawinan')
                        ->relationship('statusPerkawinan', 'name')
                        ->searchable()
                        ->preload(),
                ]),

                Grid::make(2)->schema([
                    Select::make('pendidikan_id')
                        ->label('Pendidikan')
                        ->relationship('pendidikan', 'nama')
                        ->searchable()
                        ->required()
                        ->preload(),

                    Select::make('pekerjaan_id')
                        ->label('Pekerjaan')
                        ->relationship('pekerjaan', 'name')
                        ->searchable()
                        ->preload(),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nik')->label('NIK')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('no_kk')->label('No KK'),
                Tables\Columns\TextColumn::make('shdk')->label('SHDK'),
                Tables\Columns\TextColumn::make('rw.nomor')->label('RW')->sortable(),
                Tables\Columns\TextColumn::make('rt.nomor')->label('RT')->sortable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')->label('JK'),
                Tables\Columns\TextColumn::make('statusKependudukan.name')->label('Status Kependudukan'),
                Tables\Columns\TextColumn::make('tanggal_lahir')->label('Tanggal Lahir')->date(),
                Tables\Columns\TextColumn::make('agama.name')->label('Agama'),
                Tables\Columns\TextColumn::make('pekerjaan.name')->label('Pekerjaan'),
                Tables\Columns\TextColumn::make('pendidikan.nama')->label('Pendidikan'),
                Tables\Columns\TextColumn::make('statusPerkawinan.name')->label('Status Perkawinan'),
            ])
            ->filters([
                SelectFilter::make('rw_id')->label('RW')->relationship('rw', 'nomor'),
                SelectFilter::make('rt_id')->label('RT')->relationship('rt', 'nomor'),
                SelectFilter::make('jenis_kelamin')->label('Jenis Kelamin')->options([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ]),
                SelectFilter::make('status_kependudukan_id')->label('Detail Status')->relationship('statusKependudukan', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('nama', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenduduks::route('/'),
            'create' => Pages\CreatePenduduk::route('/create'),
            'edit' => Pages\EditPenduduk::route('/{record}/edit'),
        ];
    }
}
