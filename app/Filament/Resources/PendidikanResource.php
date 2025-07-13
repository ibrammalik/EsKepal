<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendidikanResource\Pages;
use App\Filament\Resources\PendidikanResource\RelationManagers;
use App\Models\Pendidikan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PendidikanResource extends Resource
{
    protected static ?string $model = Pendidikan::class;
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->label('Nama Jenjang Pendidikan'),

                Forms\Components\Select::make('kategori')
                    ->options([
                        'Umum' => 'Umum',
                        'Khusus' => 'Khusus',
                    ])
                    ->required()
                    ->label('Kategori Pendidikan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Jenjang'),
                Tables\Columns\BadgeColumn::make('kategori')
                    ->label('Kategori')
                    ->colors([
                        'primary' => 'Umum',
                        'warning' => 'Khusus',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'Umum' => 'Umum',
                        'Khusus' => 'Khusus',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePendidikans::route('/'),
        ];
    }
}
