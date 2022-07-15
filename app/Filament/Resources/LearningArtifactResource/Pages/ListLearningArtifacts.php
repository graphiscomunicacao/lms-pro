<?php

namespace App\Filament\Resources\LearningArtifactResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\LearningArtifactResource;
use Illuminate\Contracts\View\View;

class ListLearningArtifacts extends ListRecords
{
    protected static string $resource = LearningArtifactResource::class;

    protected function getTableContentFooter(): ?View
    {
        return view('app/learning_artifacts/table-footer');
    }

    protected function getHeaderWidgets(): array
    {
        return LearningArtifactResource::getWidgets();
    }
}
