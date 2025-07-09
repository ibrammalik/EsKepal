<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RtResource\Pages;
use App\Filament\Resources\RtResource\RelationManagers;
use App\Models\Rt;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RtResource extends Resource
{
    protected static ?string $navigationLabel = 'Data RT';
    protected static ?string $navigationGroup = 'Kependudukan';
    protected static ?string $model = Rt::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nomor')
                    ->label('Nomor RT')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->unique(ignoreRecord: true, modifyRuleUsing: fn($rule) => $rule->where('rw_id', request()->input('rw_id'))),

                Select::make('rw_id')
                    ->label('Wilayah RW')
                    ->relationship('rw', 'nomor')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->disabled(function () {
                        return auth()->user()->hasRole('ketua_rw');
                    })
                    ->dehydrated()
                    ->default(function () {
                        return auth()->user()->rw_id;
                    })
                    ->visible(function () {
                        return auth()->user()->hasRole('ketua_rw') || auth()->user()->hasRole('super_admin');
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor')
                    ->label('Nomor RT')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('rw.nomor')
                    ->label('Wilayah RW')
                    ->sortable()
                    ->searchable(),

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
                SelectFilter::make('rw_id')
                    ->label('Filter RW')
                    ->relationship('rw', 'nomor')
                    ->searchable(),
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
            'index' => Pages\ManageRts::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->join('rws', 'rts.rw_id', '=', 'rws.id');

        $user = auth()->user();

        if ($user->hasRole('ketua_rw')) {
            $query->where('rts.rw_id', $user->rw_id);
        }

        return $query
            ->orderBy('rws.nomor')
            ->orderBy('rts.nomor')
            ->select('rts.*');
    }
}
