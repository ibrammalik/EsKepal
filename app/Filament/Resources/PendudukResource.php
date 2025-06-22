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
    protected static ?string $navigationGroup = 'Kependudukan';
    protected static ?string $navigationLabel = 'Data Penduduk';
    protected static ?string $pluralModelLabel = 'Penduduk';
    protected static ?string $modelLabel = 'Penduduk';
    protected static ?string $model = Penduduk::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Fieldset::make('Data Pribadi')->schema([
                TextInput::make('nik')->numeric()->label('NIK')->extraAttributes([
                    'class' => 'hide-number-arrows',
                ]),
                TextInput::make('nama'),
                DatePicker::make('tanggal_lahir'),
                Grid::make(3)->schema([
                    Textarea::make('alamat')->required(),
                    TextInput::make('rt')->label('RT')->required(),
                    TextInput::make('rw')->label('RW')->required(),
                ]),
                Select::make('jenis_kelamin')
                    ->options(['L' => 'Laki-laki', 'P' => 'Perempuan'])
                    ->required(),
                Select::make('status_kependudukan')
                    ->options([
                        'Tetap' => 'Tetap',
                        'Kontrak' => 'Kontrak',
                        'Pindah' => 'Pindah',
                        'Meninggal' => 'Meninggal',
                    ])
                    ->required(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nik')->searchable(),
                Tables\Columns\TextColumn::make('nama')->searchable(),
                Tables\Columns\TextColumn::make('rw'),
                Tables\Columns\TextColumn::make('rt'),
                Tables\Columns\TextColumn::make('jenis_kelamin')->label('JK'),
                Tables\Columns\TextColumn::make('status_kependudukan'),
                Tables\Columns\TextColumn::make('tanggal_lahir')->date(),
            ])
            ->filters([
                SelectFilter::make('rw')
                    ->label('RW')
                    ->options(Penduduk::query()->distinct()->pluck('rw', 'rw')->toArray()),
                SelectFilter::make('status_kependudukan')
                    ->options([
                        'Tetap' => 'Tetap',
                        'Kontrak' => 'Kontrak',
                        'Pindah' => 'Pindah',
                        'Meninggal' => 'Meninggal',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
