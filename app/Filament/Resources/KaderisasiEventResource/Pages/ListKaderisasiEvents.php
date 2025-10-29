<?php

namespace App\Filament\Resources\KaderisasiEventResource\Pages;

use App\Filament\Resources\KaderisasiEventResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKaderisasiEvents extends ListRecords
{
    protected static string $resource = KaderisasiEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
