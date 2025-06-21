<?php

namespace App\Filament\Resources\StatusKependudukanResource\Pages;

use App\Filament\Resources\StatusKependudukanResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageStatusKependudukans extends ManageRecords
{
    protected static string $resource = StatusKependudukanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
