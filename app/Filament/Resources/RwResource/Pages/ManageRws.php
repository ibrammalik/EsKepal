<?php

namespace App\Filament\Resources\RwResource\Pages;

use App\Filament\Resources\RwResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRws extends ManageRecords
{
    protected static string $resource = RwResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
