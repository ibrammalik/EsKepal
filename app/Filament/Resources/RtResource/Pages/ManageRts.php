<?php

namespace App\Filament\Resources\RtResource\Pages;

use App\Filament\Resources\RtResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRts extends ManageRecords
{
    protected static string $resource = RtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
