<?php

namespace App\Filament\Resources\LearningPathResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\LearningPathResource;

class ListLearningPaths extends ListRecords
{
    protected static string $resource = LearningPathResource::class;

    protected function getActions(): array
    {
        return [
            parent::getCreateAction()->label('Nova Trilha de Aprendizado'),
        ];
    }
}
