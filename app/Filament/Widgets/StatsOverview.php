<?php

namespace App\Filament\Widgets;

use App\Models\LearningArtifact;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected static ?int $sort = 1;

    protected function getCards(): array
    {
        $totalSpace = 10737418240;
        // 10Gbs
        $usedSpace = LearningArtifact::sum('size');
        $freeSpace = $totalSpace - $usedSpace;

        return [
            Card::make('Espaço em Uso:',
                LearningArtifact::formatSize($usedSpace))
                ->description('Espaço livre: ' . LearningArtifact::formatSize($freeSpace) .
                    ', do Total de: ' . LearningArtifact::formatSize($totalSpace))
                ->descriptionIcon('heroicon-o-chart-pie'),
        ];
    }
}
