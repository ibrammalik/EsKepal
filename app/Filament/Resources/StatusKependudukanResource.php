<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatusKependudukanResource\Pages;
use App\Filament\Resources\StatusKependudukanResource\RelationManagers;
use App\Models\StatusKependudukan;
use App\Traits\OnlyAdminKelurahan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StatusKependudukanResource extends Resource
{
    use OnlyAdminKelurahan;

    protected static ?string $model = StatusKependudukan::class;
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageStatusKependudukans::route('/'),
        ];
    }
}
