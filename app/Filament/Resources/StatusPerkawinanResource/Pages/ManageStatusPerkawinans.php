<?php

namespace App\Filament\Resources\StatusPerkawinanResource\Pages;

use App\Filament\Resources\StatusPerkawinanResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageStatusPerkawinans extends ManageRecords
{
    protected static string $resource = StatusPerkawinanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
