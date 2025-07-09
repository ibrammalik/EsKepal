<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
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
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $navigationLabel = 'Data User';
    protected static ?string $navigationGroup = 'Manajemen Akses';
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
                    ->required(fn(string $context): bool => $context === 'create')
                    ->maxLength(255),

                Select::make('roles')
                    ->label('Peran')
                    ->relationship('roles', 'name')
                    ->preload()
                    ->searchable()
                    ->required()
                    ->reactive(),

                Select::make('rw_id')
                    ->label('Wilayah RW')
                    ->relationship('rw', 'nomor')
                    ->searchable()
                    ->preload()
                    ->visible(function (callable $get) {
                        $roleIds = $get('roles'); // this is an array of role IDs

                        if (! is_array($roleIds)) return false;

                        // Check if any of those roles has name === 'ketua_rw'
                        return Role::whereIn('id', $roleIds)
                            ->pluck('name')
                            ->contains('ketua_rw');
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable()->sortable(),

                TextColumn::make('email')->label('Email')->searchable()->sortable(),

                TextColumn::make('role.name')
                    ->label('Peran')
                    ->getStateUsing(fn($record) => $record->getRoleNames()->first() ?? '-')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'super_admin' => 'danger',
                        'ketua_rw' => 'success',
                        default => 'gray'
                    }),

                TextColumn::make('wilayah_kerja')
                    ->label('Wilayah')
                    ->getStateUsing(function ($record) {
                        $role = $record->getRoleNames()->first();
                        if ($role === 'ketua_rw') {
                            return 'RW ' . ($record->rw?->nomor ?? '-');
                        } elseif ($role === 'super_admin') {
                            return 'Kelurahan';
                        } else {
                            return '-';
                        }
                    })
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function afterCreate($record, array $data): void
    {
        if (isset($data['role'])) {
            $record->syncRoles([$data['role']]);
        }
    }

    public static function afterSave($record, array $data): void
    {
        if (isset($data['role'])) {
            $record->syncRoles([$data['role']]);
        }
    }
}
