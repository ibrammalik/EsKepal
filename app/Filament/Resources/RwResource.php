<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RwResource\Pages;
use App\Filament\Resources\RwResource\RelationManagers;
use App\Models\Rw;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RwResource extends Resource
{
    protected static ?string $navigationLabel = 'Data RW';
    protected static ?string $navigationGroup = 'Kependudukan';
    protected static ?string $model = Rw::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nomor')
                    ->label('Nomor')
                    ->integer()
                    ->minValue(1)
                    ->required()
                    ->unique(ignoreRecord: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor')->label('Nomor')->searchable()->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Dirubah')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('nomor')
                    ->label('Filter Nomor RW')
                    ->options(
                        fn() => Rw::query()->pluck('nomor', 'nomor')->sort()->toArray()
                    )
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('nomor', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRws::route('/'),
        ];
    }
}
