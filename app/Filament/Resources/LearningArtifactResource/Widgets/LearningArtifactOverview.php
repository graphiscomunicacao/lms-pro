<?php

namespace App\Filament\Resources\LearningArtifactResource\Widgets;

use App\Models\LearningArtifact;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class LearningArtifactOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getCards(): array
    {
        return [
            Card::make('Materiais recentes (30 dias):', LearningArtifact::where('created_at', '>', now()->subDays(30))->count()),
            Card::make('Tamanho Total:', LearningArtifact::formatSize(LearningArtifact::sum('size'))),
            Card::make('Tamanho Médio:', LearningArtifact::formatSize(LearningArtifact::averageSize())),
        ];
    }}
