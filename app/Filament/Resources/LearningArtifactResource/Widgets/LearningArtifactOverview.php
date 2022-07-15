<?php

namespace App\Filament\Resources\LearningArtifactResource\Widgets;

use App\Models\LearningArtifact;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class LearningArtifactOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total de Materiais de Ensino', LearningArtifact::count()),
            Card::make('Tamanho total de Materiais de Ensino', LearningArtifact::count()),
            Card::make('Tamanho Médio de Materiais de Ensino', LearningArtifact::count()),
        ];
    }}
