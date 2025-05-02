<?php

namespace App\Filament\Resources\ParfumResource\Pages;

use App\Filament\Resources\ParfumResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditParfum extends EditRecord
{
    protected static string $resource = ParfumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
