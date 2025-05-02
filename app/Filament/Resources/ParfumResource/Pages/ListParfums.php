<?php

namespace App\Filament\Resources\ParfumResource\Pages;

use App\Filament\Resources\ParfumResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParfums extends ListRecords
{
    protected static string $resource = ParfumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
