<?php

namespace App\Filament\Resources\ProblemCategoryResource\Pages;

use App\Filament\Resources\ProblemCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProblemCategory extends EditRecord
{
    protected static string $resource = ProblemCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
